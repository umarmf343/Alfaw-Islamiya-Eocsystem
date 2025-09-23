# AlFawz Laravel Application

This directory now houses the full-stack Laravel app for the AlFawz Qur'an Institute. Blade views deliver the frontend, Sanctum secures APIs, and queues/schedules handle heavy lifting such as Whisper transcription and leaderboard caching.

## Requirements

Install the following tooling before you begin:

| Tool | Recommended version | Windows-friendly option |
| --- | --- | --- |
| PHP | 8.2+ | [Laravel Herd](https://herd.laravel.com/), [Laragon](https://laragon.org/), or XAMPP with PHP 8.2 |
| Composer | 2.7+ | Bundled with Laravel Herd/Laragon or install from [getcomposer.org](https://getcomposer.org/download/) |
| Node.js & npm | Node 18+ (ships with npm 9+) | [Node.js LTS installer](https://nodejs.org/) |
| Database | MySQL 8 / MariaDB 10.6 (or SQLite for quick testing) | Use the database bundled with your PHP stack |
| Git | Latest | [Git for Windows](https://git-scm.com/download/win) |

> **Tip:** On Windows you can run the commands below from PowerShell, Windows Terminal, or Git Bash. If you prefer WSL, install Ubuntu in WSL and follow the Linux/macOS instructions unchanged.

## Project setup (Linux/macOS/WSL)

```bash
cd backend
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan storage:link  # enables public asset serving
php artisan migrate --seed
npm run dev               # or `npm run build` for a production bundle
php artisan serve
```

Visit `http://localhost:8000` to browse the animated landing page, register as a student or teacher, and explore the dashboards.

## Project setup (Windows PowerShell)

```powershell
Set-Location backend
composer install
npm install
Copy-Item .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
npm run dev      # keep this running in a second terminal for hot reloads
php artisan serve
```

If you see database connection errors, confirm that MySQL/MariaDB is running and that the credentials in `.env` are correct for your Windows stack (Laragon, XAMPP, or Docker). The default values match `DB_DATABASE=alfawz`, `DB_USERNAME=root`, and an empty password.

### SQLite quick start (no MySQL required)

For smoke testing you can switch to SQLite:

```bash
php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
php artisan config:clear
php artisan migrate --seed
```

Then edit `.env` so the database section reads:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/backend/database/database.sqlite
```

Comment out the `DB_HOST`, `DB_PORT`, `DB_USERNAME`, and `DB_PASSWORD` lines. Laravel will now use the bundled SQLite file.

## Environment variables

Populate the following keys in `.env` before running queues or integrations:

- `APP_URL` – base URL you serve the site from (e.g. `http://localhost:8000`).
- `FILESYSTEM_DISK` – `public` for local storage or set to an S3-compatible disk.
- `QUEUE_CONNECTION` – `database` seeds the required tables; switch to `redis` if you deploy with Redis.
- `PAYSTACK_PUBLIC_KEY`, `PAYSTACK_SECRET_KEY`, `PAYSTACK_WEBHOOK_SECRET` – required for live Paystack payments.
- `OPENAI_API_KEY`, `OPENAI_WHISPER_MODEL` – needed for recitation transcription via Whisper.
- `MAIL_MAILER` – defaults to `log`, but you can configure SMTP (`MAIL_HOST`, `MAIL_PORT`, etc.) when ready.

## Verifying the install

Run the automated checks any time you change dependencies or after onboarding:

```bash
npm run build      # compiles the Tailwind/Vite assets without errors
php artisan test   # executes the Laravel feature and unit tests
```

Both commands should finish without failures. If `npm run build` fails on Windows, ensure your antivirus is not blocking Node and that you launched the terminal with the correct permissions.

## Operational notes

- `queue:work` must be running for `ProcessRecitationSubmission` jobs that call the Whisper API and write Hasanat ledgers.
- `leaderboard:capture` is scheduled hourly in `app/Console/Kernel.php`; add it to cron or Windows Task Scheduler if you are not using `php artisan schedule:work`.
- Paystack webhooks hit `/api/payments/webhook` and require `PAYSTACK_WEBHOOK_SECRET` to be configured. Successful charges automatically enrol students using the payload metadata.
- Audio uploads are stored on the `public` disk. Run `php artisan storage:link` in environments serving files locally or configure S3-compatible storage.

## Testing

Run all automated checks with:

```bash
php artisan test
```

Tests assert registration flows, webhook fulfilment, queued recitation processing, and leaderboard captures.
