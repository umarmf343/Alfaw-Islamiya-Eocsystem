'use client';

import Image from 'next/image';
import Link from 'next/link';
import { useEffect, useState } from 'react';
import axios from 'axios';

interface LeaderboardEntry {
  rank: number;
  name: string;
  score: number;
}

export default function Home() {
  const [leaderboard, setLeaderboard] = useState<LeaderboardEntry[]>([]);

  useEffect(() => {
    let active = true;

    axios
      .get<LeaderboardEntry[]>(
        '/api/gamification/leaderboard',
        {
          baseURL: process.env.NEXT_PUBLIC_API_BASE ?? 'http://localhost:8000'
        }
      )
      .then((response) => {
        if (active) {
          setLeaderboard(response.data);
        }
      })
      .catch(() => {
        if (active) {
          setLeaderboard([]);
        }
      });

    return () => {
      active = false;
    };
  }, []);

  return (
    <main className="mx-auto flex min-h-screen w-full max-w-5xl flex-col gap-10 px-6 py-16">
      <section className="rounded-3xl bg-white p-10 shadow-xl">
        <div className="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
          <div>
            <h1 className="text-4xl font-semibold text-[#5b1d2a]">AlFawz Qur&apos;an Institute</h1>
            <p className="mt-3 max-w-xl text-lg text-[#36191b]">
              Track your Hasanat, perfect your recitation with Whisper-powered feedback, and stay motivated with streaks,
              badges, and class leaderboards.
            </p>
            <div className="mt-6 flex flex-wrap gap-4">
              <Link
                href="/app"
                className="rounded-full bg-[#a43e52] px-6 py-3 text-white transition hover:bg-[#872f40]"
              >
                Launch Dashboard
              </Link>
              <Link
                href="/learn-more"
                className="rounded-full border border-[#a43e52] px-6 py-3 text-[#a43e52] transition hover:bg-[#fbe4e8]"
              >
                Explore Features
              </Link>
            </div>
          </div>
          <Image src="/globe.svg" alt="Globe" width={160} height={160} className="self-center" />
        </div>
      </section>

      <section className="grid gap-6 md:grid-cols-3">
        {[
          {
            title: 'Recitation Coach',
            description: 'Record submissions and receive Whisper-powered pronunciation guidance in minutes.'
          },
          {
            title: 'Memorization SRS',
            description: 'SM-2 scheduling keeps your memorization reviews on track with personalized intervals.'
          },
          {
            title: 'Accountability',
            description: 'Daily habits, streak tracking, and Hasanat rewards encourage consistent Qur’an engagement.'
          }
        ].map((feature) => (
          <article key={feature.title} className="rounded-2xl bg-white p-6 shadow">
            <h2 className="text-xl font-semibold text-[#5b1d2a]">{feature.title}</h2>
            <p className="mt-2 text-sm leading-6 text-[#36191b]">{feature.description}</p>
          </article>
        ))}
      </section>

      <section className="rounded-3xl bg-white p-10 shadow-xl">
        <div className="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
          <div>
            <h2 className="text-2xl font-semibold text-[#5b1d2a]">Top Students</h2>
            <p className="mt-2 text-[#36191b]">Celebrate excellence and encourage healthy competition in every class.</p>
          </div>
          <Image src="/window.svg" alt="Leaderboard" width={120} height={120} />
        </div>
        <ul className="mt-6 divide-y divide-[#f5d9de]">
          {leaderboard.map((entry) => (
            <li key={entry.rank} className="flex items-center justify-between py-3">
              <span className="font-medium text-[#36191b]">
                #{entry.rank} {entry.name}
              </span>
              <span className="rounded-full bg-[#fbe4e8] px-4 py-1 text-sm text-[#a43e52]">{entry.score} pts</span>
            </li>
          ))}
          {leaderboard.length === 0 && (
            <li className="py-3 text-sm text-[#83636a]">Leaderboard data will appear once students start reciting.</li>
          )}
        </ul>
      </section>
    </main>
  );
}
