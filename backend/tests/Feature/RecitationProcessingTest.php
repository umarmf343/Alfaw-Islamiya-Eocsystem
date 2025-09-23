<?php

namespace Tests\Feature;

use App\Jobs\ProcessRecitationSubmission;
use App\Models\Recitation;
use App\Models\User;
use App\Services\RecitationFeedbackService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class RecitationProcessingTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_recitation_upload_dispatches_processing_job(): void
    {
        Storage::fake('public');
        Queue::fake();

        $user = User::factory()->create();
        $user->assignRole('Student');

        Sanctum::actingAs($user);

        $response = $this->post('/api/recitations', [
            'surah' => 'Al-Fatihah',
            'ayah_range' => '1-7',
            'expected_text' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ',
            'audio' => UploadedFile::fake()->create('recitation.mp3', 100, 'audio/mpeg'),
        ]);

        $response->assertStatus(202);
        $this->assertEquals('processing', $response->json('recitation.status'));

        Queue::assertPushed(ProcessRecitationSubmission::class);
    }

    public function test_processing_job_updates_recitation_with_feedback(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $user->assignRole('Student');

        $audio = UploadedFile::fake()->create('recitation.mp3', 100, 'audio/mpeg');
        $path = $audio->store('recitations/' . $user->id, 'public');

        $recitation = Recitation::create([
            'user_id' => $user->id,
            'surah' => 'Al-Fatihah',
            'ayah_range' => '1-7',
            'audio_path' => $path,
            'expected_text' => 'بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ',
            'status' => 'processing',
        ]);

        $feedbackService = Mockery::mock(RecitationFeedbackService::class);
        $feedbackService
            ->shouldReceive('transcribeAndScore')
            ->once()
            ->andReturn([
                'transcript' => 'Bismillahi r-Rahmani r-Raheem',
                'score' => 92.5,
                'notes' => ['Great tajweed control'],
            ]);

        app()->instance(RecitationFeedbackService::class, $feedbackService);

        $job = new ProcessRecitationSubmission($recitation->id);
        $job->handle(app(RecitationFeedbackService::class), app(\App\Services\HasanatService::class));

        $recitation->refresh();

        $this->assertEquals('completed', $recitation->status);
        $this->assertEquals(92.5, $recitation->score);
        $this->assertNotEmpty($recitation->feedback);
        $this->assertDatabaseHas('hasanat_ledgers', [
            'recitation_id' => $recitation->id,
        ]);
    }
}
