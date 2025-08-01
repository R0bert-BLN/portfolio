import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/auth/LoginView.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import ProfileView from "@/views/admin/ProfileView.vue";
import {useAuthStore} from "@/stores/AuthStore.ts";
import EducationView from "@/views/admin/EducationView.vue";
import WorkView from "@/views/admin/WorkView.vue";
import SkillView from "@/views/admin/SkillView.vue";
import ProjectView from "@/views/admin/ProjectView.vue";
import ContactView from "@/views/admin/ContactView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: LoginView,
        },
        {
            path: '/admin',
            name: 'admin',
            meta: {
                requiresAuth: true,
            },
            component: AdminLayout,
            children: [
                {
                    path: '',
                    name: 'admin-home',
                    redirect: '/admin/profile'
                },
                {
                    path: 'profile',
                    name: 'admin-profile',
                    component: ProfileView
                },
                {
                    path: 'education',
                    name: 'admin-education',
                    component: EducationView
                },
                {
                    path: 'work',
                    name: 'admin-work',
                    component: WorkView
                },
                {
                    path: 'skill',
                    name: 'admin-skill',
                    component: SkillView
                },
                {
                    path: 'project',
                    name: 'admin-project',
                    component: ProjectView
                },
                {
                    path: 'contact',
                    name: 'admin-contact',
                    component: ContactView
                }
            ]
        },
    ],
})

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();

    if (to.name === 'login' && authStore.isAuthenticated) {
        next({ name: 'admin' });
        return;
    }

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({name: 'login'});
        return;
    }

    next();
})

export default router
