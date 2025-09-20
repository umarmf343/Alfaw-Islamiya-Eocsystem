import type { Config } from 'tailwindcss';

const config: Config = {
  content: ['./src/**/*.{ts,tsx}'],
  theme: {
    extend: {
      colors: {
        maroon: '#5b1d2a',
        milk: '#faf5f0',
        gold: '#c79a3d'
      }
    }
  },
  plugins: []
};

export default config;
