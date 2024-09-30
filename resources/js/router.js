import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/', component: () => import('./Pages/MainPage.vue'),
            name: 'main'
        },
        {
            path: '/animes', component: () => import('./Pages/Animes/Index.vue'),
            name: 'animes.index',
        },
        {
            path: '/anime/:slug',
            name: 'anime.show'
        },
        {
            path: '/doramas', component: () => import('./Pages/Doramas/Index.vue'),
            name: 'doramas.index'
        },
        {
            path: '/search', component: () => import('./Pages/SearchPage.vue'),
            name: 'search'
        },
        {
            path: '/subscription', component: () => import('./Pages/MainPage.vue'),
            name: 'subscription'
        },
        {   path: '/admin',
            name: 'admin',
            component: () => {
                window.location.href = 'https://admin.reina.online';
            }
        },
        // {   path: '/login',
        //     name: 'login',
        //     component: () => {
        //         window.location.href = 'https://auth.reina.online/login';
        //     }
        // },
        // {   path: '/logout',
        //     name: 'logout',
        //     component: () => {
        //         window.location.href = 'https://auth.reina.online/login';
        //     }
        // },
        // {   path: '/register',
        //     name: 'register',
        //     component: () => {
        //         window.location.href = 'https://auth.reina.online/register';
        //     }
        // },
        // {
        //     path: '/logout', component: () => import('./Pages/Auth/AppLayout.vue'),
        //     name: 'logout'
        // },
        // {   path: '/:pathMatch(.*)*', component: () => import('./Pages/MainPage.vue'),
        //     name: '404',
        //     redirect: "/"
        // }
    ]
})

export default router
