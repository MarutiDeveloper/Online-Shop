import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    manifest: true,  // Make sure manifest is enabled
    outDir: 'public/build',  // This should match your Laravel configuration
    rollupOptions: {
      input: 'resources/js/app.js',  // Your entry file for the build
    },
  },
});