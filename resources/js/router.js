import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/', component: () => import('./Pages/MainPage.vue'),
            name: 'main'
        },
        //  Anime
        {
            path: '/animes', component: () => import('./Pages/Animes/AnimeIndexPage.vue'),
            name: 'animes.index',
        },
        {
            path: '/animes/:slug',
            component: () => import('./Pages/Animes/AnimeShowPage.vue'),
            name: 'animes.show',
            props: true
        },
        //  Dorama
        {
            path: '/doramas', component: () => import('./Pages/Doramas/DoramaIndexPage.vue'),
            name: 'doramas.index'
        },
        {
            path: '/doramas/:slug',
            component: () => import('./Pages/Doramas/DoramaShowPage.vue'),
            name: 'doramas.show',
            props: true
        },
        {
            path: '/search', component: () => import('./Pages/SearchPage.vue'),
            name: 'search'
        },
        {
            path: '/subscription', component: () => import('./Pages/MainPage.vue'),
            name: 'subscription'
        },
        {   path: '/auth',
            name: 'auth',
            component: () => {
                window.location.href = 'https://admin.reina.online';
            }
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
