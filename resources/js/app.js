import './bootstrap'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import Particles from 'vue3-particles'

createApp(App)
    .use(router)
    .use(Particles)
    .mount('#app')
