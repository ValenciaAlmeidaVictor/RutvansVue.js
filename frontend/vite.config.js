import { fileURLToPath, URL } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
// import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    // vueDevTools(), // Si necesitas habilitar Vue DevTools en producción, puedes quitar el comentario
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: {
    port: 8000,  // Aquí cambiamos el puerto a 8000
    proxy: {
      '/api': {
        target: 'http://localhost:8000', // URL de tu servidor backend Laravel
        changeOrigin: true,              // Cambia el origen de las solicitudes para que Laravel lo acepte
        secure: false,                   // Deshabilita la verificación SSL (útil para localhost)
        rewrite: (path) => path.replace(/^\/api/, ''), // Reescribe la URL para que no incluya '/api'
      },
    },
  },
});
