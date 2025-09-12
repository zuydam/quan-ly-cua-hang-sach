import './style.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import money from 'v-money3'
const app = createApp(App)

app.use(router)
app.use(money) // kích hoạt directive v-money
app.mount('#app')
