import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { createNotivue } from 'notivue'

import App from './App.vue'
import router from './router'
import vuetify from "@/plugins/vuetify.ts";
import './assets/main.css'

const app = createApp(App)
const notivue = createNotivue()

app.use(createPinia())
app.use(router)
app.use(notivue)
app.use(vuetify)

app.mount('#app')
