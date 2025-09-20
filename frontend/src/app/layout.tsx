import type { Metadata } from 'next';
import type { ReactNode } from 'react';
import './globals.css';

export const metadata: Metadata = {
  title: "AlFawz Qur'an Institute",
  description: 'Immersive Qur’an learning platform with Hasanat tracking and memorization tools.'
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="en" className="scroll-smooth">
      <body className="min-h-screen bg-[#faf5f0] text-[#36191b]">
        {children}
      </body>
    </html>
  );
}
