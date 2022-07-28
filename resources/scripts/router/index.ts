import {createRouter, createWebHistory} from 'vue-router'
import DashboardView from "@/views/DashboardView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/admin/:module/:model/:id?/',
            name: 'module',
            component: () => import('../views/ModuleView.vue'),
            meta: {
                middleware: 'auth'
            }
        },
        {
            path: '/admin/',
            name: 'dashboard',
            component: () => DashboardView,
            meta: {
                middleware: 'auth'
            }
        },
    ]
});

export default router
