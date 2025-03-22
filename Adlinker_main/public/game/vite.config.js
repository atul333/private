import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  root: './src',
  base: '/game/',
  server: {
    port: 5174,
    strictPort: true,
    host: true
  },
  build: {
    outDir: '../dist',
    emptyOutDir: true,
    sourcemap: true
  }
});