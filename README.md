# AlFawz Qur'an Institute Ecosystem

## Overview

The AlFawz Qur'an Institute ecosystem is a full-stack web platform designed to deliver an immersive Islamic learning experience. It focuses on Qur'an recitation, memorization, progress tracking, and habit-building for students and teachers within the institute.

## Tech Stack

- **Backend:** Laravel 10/11 (PHP 8.2)
- **Frontend:** Next.js with Tailwind CSS
- **Database:** MySQL / MariaDB
- **AI Services:** OpenAI Whisper API for speech-to-text validation
- **Payments:** Paystack
- **Hosting:** cPanel shared hosting with Cloudflare CDN and S3-compatible storage for media assets

## Core Features

### User Roles & Authentication

- **Admin:** Manage users, classes, payments, and system configuration.
- **Teacher:** Assigned to classes by admins to review recitations, assignments, and student progress.
- **Student:** Track progress, submit recitations, and participate in gamification features.
- Authentication implemented with Laravel Sanctum and role management handled through Spatie Laravel Permission.

### Hasanat System

- Calculates Hasanat as `Hasanat = Number of Arabic Letters × 10` for each recitation.
- Tracks Hasanat points in real time so students can monitor spiritual progress.

### Recitation & Memorization

- Displays Qur'an text in Uthmani script with translations.
- Validates recitations using OpenAI Whisper to detect pronunciation errors, missed words, and timing issues.
- Implements an SM-2 spaced repetition system for memorization reviews, including flashcards for challenging verses and words.

### Teacher Dashboard

- Enables review of student submissions, grading, and personalized feedback (text or audio).
- Provides analytics on class performance to highlight both top achievers and students needing assistance.
- Teachers cannot create classes themselves; admins handle class assignments.

### Admin Dashboard

- Controls user management, role assignment, class creation, and teacher assignments.
- Monitors and manages payment processing, tuition, and subscription plans through Paystack integration.
- Provides Hasanat reporting and progress oversight across the platform.

### Payments (Paystack)

- Supports one-time payments and recurring subscriptions for class enrollments.
- Includes webhook handling to confirm payments and grant course access after successful transactions.

### UI/UX & Accessibility

- Tailwind CSS-driven responsive design with a maroon primary palette, milk secondary palette, and gold accents.
- Personalized dashboards for students and teachers.
- Accessibility features: keyboard navigation, RTL support for Arabic, dyslexic-friendly fonts, and language switching between Arabic and English.

### Gamification & Habit Building

- Leaderboards at global and class levels.
- Badge system for milestones (e.g., "Surah Master", "30-day Streak").
- Daily streak tracking and habit check-ins for continuous engagement.

### Offline Mode (PWA)

- Provides offline access to recent ayahs, translations, and audio segments using IndexedDB.
- Allows offline recording of recitations with synchronization upon reconnecting to the internet.

### Security & Privacy

- Token-based authentication using Laravel Sanctum.
- Role-based access control via Spatie Laravel Permission.
- Secure media uploads to S3-compatible storage with mandatory HTTPS.
- GDPR-aligned features: data export, deletion, and retention policies.

## Backend Implementation Outline (Laravel)

1. Configure Sanctum and Spatie permissions for Admin, Teacher, and Student roles.
2. Build models and migrations for users, classrooms, assignments, progress tracking, payments, Hasanat ledger, badges, and leaderboards.
3. Create RESTful API endpoints for authentication, recitation submissions, payment processing, class management, and gamification features.
4. Integrate OpenAI Whisper for transcription and recitation feedback.
5. Implement the SM-2 spaced repetition algorithm and Hasanat calculations.
6. Utilize queues and scheduled tasks for background processing (e.g., Whisper transcription, leaderboard updates).

### Repository Layout

- `backend/` – Laravel-inspired API skeleton with controllers, services, policies, and database migrations covering Hasanat, recitations, memorisation reviews, gamification, and Paystack payments.
- `frontend/` – Next.js application styled with Tailwind CSS delivering dashboards, marketing, and leaderboard views.
- `README.md` – Project overview and implementation guidance.

## Frontend Implementation Outline (Next.js)

1. Build dashboards for students, teachers, and admins with Tailwind CSS components.
2. Implement authentication flows and secure API interactions using SWR or React Query.
3. Develop recitation interfaces with audio recording, feedback visualization, and Hasanat tracking.
4. Deliver gamification experiences with leaderboards, badges, and streak tracking.
5. Implement PWA features for offline reading and recording with IndexedDB storage.

## Deployment Notes

1. Deploy Laravel backend on cPanel, keeping backend files organized in subdirectories.
2. Generate a static build for the Next.js frontend and place it in `public/app` for Laravel to serve.
3. Configure environment variables for database, Paystack, Whisper API, and S3-compatible storage.
4. Set up cron jobs for queue workers, spaced repetition reminders, leaderboard snapshots, and other scheduled tasks.
5. Enable SSL, Cloudflare CDN, and caching strategies for performance and security.

---

This document serves as a roadmap for building the AlFawz Qur'an Institute application, ensuring the platform remains focused on Qur'an education, spiritual growth, and meaningful engagement for students and teachers alike.
