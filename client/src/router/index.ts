import { createRouter, createWebHistory } from 'vue-router'
import LoginView from "@/views/auth/LoginView.vue";
import AdminView from "@/views/admin/AdminView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminView
        }
    ],
})

export default router
