# AlFawz Laravel Application

This directory now houses the full-stack Laravel app for the AlFawz Qur'an Institute. Blade views deliver the frontend, Sanctum secures APIs, and queues/schedules handle heavy lifting such as Whisper transcription and leaderboard caching.

## Quick start

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve
```

Visit `http://localhost:8000` to browse the animated landing page, register as a student or teacher, and explore the dashboards.

## Operational notes

- `queue:work` must be running for `ProcessRecitationSubmission` jobs that call the Whisper API and write Hasanat ledgers.
- `leaderboard:capture` is scheduled hourly in `app/Console/Kernel.php`; add it to cron if you are not using `php artisan schedule:work`.
- Paystack webhooks hit `/api/payments/webhook` and require `PAYSTACK_WEBHOOK_SECRET` to be configured. Successful charges automatically enrol students using the payload metadata.
- Audio uploads are stored on the `public` disk. Run `php artisan storage:link` in environments serving files locally or configure S3-compatible storage.

## Testing

Run all automated checks with:

```bash
php artisan test
```

Tests assert registration flows, webhook fulfilment, queued recitation processing, and leaderboard captures.
