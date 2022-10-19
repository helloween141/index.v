import {createRouter, createWebHistory} from 'vue-router'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/admin/:module/:model/:id?',
            name: 'module',
            component: () => import('../views/ModuleView.vue'),
            meta: {
                middleware: 'auth'
            }
        },
        {
            path: '/admin/profile',
            name: 'profile',
            component: () => import('../views/ProfileView.vue'),
            meta: {
                middleware: 'auth'
            }
        },
        {
            path: '/admin',
            name: 'dashboard',
            component: () => import('../views/DashboardView.vue'),
            meta: {
                middleware: 'auth'
            }
        },
    ]
});

export default router
