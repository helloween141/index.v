import {createRouter, createWebHistory} from 'vue-router'
import {useUserStore} from "@/stores/user";
import DashboardView from "@/views/DashboardView.vue";
import LoginView from "@/views/LoginView.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/admin/:module/:model/:id?/',
            name: 'module',
            component: () => import('../views/ModuleView.vue'),
        },
        {
            path: '/admin/',
            name: 'dashboard',
            component: () => DashboardView,
            meta: {
                middleware: 'auth',
                title: 'Главная'
            }
        },
        {
            path: '/admin/',
            name: 'login',
            component: () => LoginView,
            meta: {
                middleware: 'guest',
                title: 'Авторизация'
            }
        },
    ]
});

router.beforeEach(async (to, from, next) => {
    try {
        document.title = `${to.meta.title}`
        const userStore = useUserStore()
        await userStore.getUserData()
        if (to.meta.middleware === 'guest') {
            if (userStore.auth) {
                next({name: 'dashboard'})
            }
            next()
        } else {
            if (userStore.auth) {
                next()
            } else {
                next({name: 'login'})
            }
        }
    } catch (e) {
        console.log(e)
    }
})

export default router
