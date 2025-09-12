import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'
import Components from 'unplugin-vue-components/vite';


// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    Components({
      dirs: ['src/components'], // 👈 nơi chứa các component
      extensions: ['vue'],      // 👈 định dạng file
      deep: true,               // 👈 quét cả thư mục con
      dts: true                 // 👈 tạo file .d.ts nếu dùng TypeScript
    }),
    vueDevTools(),
  ],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
})
