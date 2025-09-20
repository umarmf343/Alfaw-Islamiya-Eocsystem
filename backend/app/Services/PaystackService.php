<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class PaystackService
{
    public function initializeTransaction(User $user, array $data): array
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $user->email,
                'amount' => (int) ($data['amount'] * 100),
                'currency' => $data['currency'],
                'reference' => $data['reference'],
                'metadata' => $data['metadata'] ?? [],
                'callback_url' => config('app.url') . '/paystack/callback',
            ])->throw()->json();

        Payment::create([
            'user_id' => $user->id,
            'reference' => $data['reference'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'status' => 'initialized',
            'metadata' => $data['metadata'] ?? [],
        ]);

        return Arr::get($response, 'data', []);
    }

    public function handleWebhook(array $payload, ?string $signature): void
    {
        if (! $this->isValidSignature($payload, $signature)) {
            abort(401, 'Invalid signature');
        }

        $event = $payload['event'] ?? null;
        $data = $payload['data'] ?? [];
        $reference = $data['reference'] ?? null;

        if (! $reference) {
            return;
        }

        $payment = Payment::where('reference', $reference)->first();
        if (! $payment) {
            return;
        }

        if ($event === 'charge.success') {
            $payment->update([
                'status' => 'successful',
                'metadata' => $data,
            ]);
        }
    }

    public function refund(Payment $payment, float $amount): array
    {
        $response = Http::withToken(config('services.paystack.secret_key'))
            ->post('https://api.paystack.co/refund', [
                'transaction' => $payment->reference,
                'amount' => (int) ($amount * 100),
            ])->throw()->json();

        $payment->update([
            'status' => 'refunded',
        ]);

        return Arr::get($response, 'data', []);
    }

    protected function isValidSignature(array $payload, ?string $signature): bool
    {
        $secret = config('services.paystack.webhook_secret');

        if (! $signature || ! $secret) {
            return false;
        }

        $generated = hash_hmac('sha512', json_encode($payload), $secret);

        return hash_equals($generated, $signature);
    }
}
