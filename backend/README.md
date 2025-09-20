# AlFawz Backend

This directory contains a Laravel-inspired API skeleton tailored for the AlFawz Qur'an Institute platform.

## Getting Started

1. Install dependencies: `composer install`
2. Copy `.env.example` to `.env` and configure database, Paystack, Whisper, and S3 credentials.
3. Generate the application key: `php artisan key:generate`
4. Run migrations: `php artisan migrate`
5. Start the development server: `php artisan serve`

## Code Style

* Controllers focus on orchestration and delegate work to services.
* Form requests validate inbound data and authorize resource access.
* Policies enforce role-specific authorization.
* Services encapsulate domain logic like Hasanat, spaced repetition, payments, and gamification.

## Testing

Execute the test suite with `php artisan test`.
