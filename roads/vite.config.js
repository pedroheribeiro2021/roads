import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: ['resources/js/app.js', 'resources/css/app.css'],
      refresh: true,
    }),
  ],
  server: {
    host: '127.0.0.1',
    port: 5173,
    cors: {
      origin: 'http://127.0.0.1:8000',
      credentials: true,
    },
  },
});
