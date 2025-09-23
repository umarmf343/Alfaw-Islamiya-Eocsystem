# AlFawz Qur'an Institute Platform

AlFawz is a Laravel-first learning environment that blends Qur'an memorisation, recitation feedback, habit tracking, and institute administration inside a single PHP application. The platform now ships with a polished Blade/Tailwind interface, role-aware dashboards, asynchronous Whisper transcription, and production-ready Paystack fulfilment.

## Tech stack

- **Framework:** Laravel 11 with Blade templates
- **Styling:** Tailwind CSS with animated gradient UI components
- **Auth & Roles:** Laravel Sanctum + Spatie Laravel Permission
- **Speech AI:** OpenAI Whisper API (async queue jobs)
- **Payments:** Paystack with webhook-driven enrolment automation
- **Database:** MySQL or MariaDB
- **Build tooling:** Vite + PostCSS for asset compilation

## Feature highlights

- 🌙 **Role-based dashboards** – bespoke experiences for students, teachers, and admins rendered in Blade with glassmorphism-inspired UI.
- 🎧 **Queued recitation processing** – audio uploads are stored on the `public` disk and dispatched to background jobs that call Whisper, score similarity, and write Hasanat ledger entries.
- 💳 **Paystack fulfilment** – successful webhooks flag payments as `successful` and automatically enrol students in classrooms or assign premium roles.
- 🏆 **Gamification cadence** – hourly `leaderboard:capture` snapshots feed the landing page and dashboards with cached rankings.
- 🛠️ **Operational clarity** – README, `.env.example`, and scheduler/queue hints ensure deployers can wire storage, workers, and cron with confidence.

## Local development

1. **Install PHP dependencies**
   ```bash
   cd backend
   composer install
   ```
2. **Install Node dependencies & build assets**
   ```bash
   npm install
   npm run dev
   ```
3. **Environment**
   - Copy `.env.example` to `.env` and configure database, Paystack, and OpenAI keys.
   - Generate an application key: `php artisan key:generate`.
   - Link storage for public assets: `php artisan storage:link`.
4. **Database & roles**
   ```bash
   php artisan migrate --seed
   ```
   The seeder seeds the `Admin`, `Teacher`, and `Student` roles and an initial admin user (`admin@example.com`).
5. **Serve**
   ```bash
   php artisan serve
   ```
   Visit `http://localhost:8000` to explore the animated landing page and sign up as a student or teacher.

## Operations checklist

| Concern | Command / Notes |
| --- | --- |
| Queue worker | `php artisan queue:work` (or Supervisor) – required for `ProcessRecitationSubmission` jobs |
| Leaderboard snapshots | `php artisan leaderboard:capture` – scheduled hourly via `app/Console/Kernel.php` |
| Horizon alternative | Configure if scaling beyond single worker |
| Paystack webhook | Point Paystack to `/api/payments/webhook` with the configured `PAYSTACK_WEBHOOK_SECRET` |
| Whisper audio storage | Configure `FILESYSTEM_DISK=public` or S3-compatible disk and ensure uploads are retained |

## Testing

Run the full PHP test suite from the `backend` directory:

```bash
php artisan test
```

The suite now covers registration, async recitation jobs, Paystack webhook fulfilment, and leaderboard capture.

---

Built with ❤️ to help learners recite, memorise, and thrive.
