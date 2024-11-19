import { createRouter, createWebHistory } from 'vue-router'
import {useAuthStore} from "./Stores/authStore.js";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./Layouts/MainLayout.vue'),
            children: [
                {
                    path: '',
                    component: () => import('./Pages/MainPage.vue'),
                    name: 'main',
                },
                {
                    path: '/search', component: () => import('./Pages/SearchPage.vue'),
                    name: 'search'
                },
            ],
        },
        //  Anime
        {
            path: '/animes',
            component: () => import('./Layouts/MainLayout.vue'),
            children: [
                {
                    path: '', component: () => import('./Pages/Animes/AnimeIndexPage.vue'),
                    name: 'animes.index',
                },
                {
                    path: ':slug', component: () => import('./Pages/Animes/AnimeShowPage.vue'),
                    name: 'animes.show',
                    props: true
                },
            ],
        },
        //  Dorama
        {
            path: '/doramas',
            component: () => import('./Layouts/MainLayout.vue'),
            children: [
                {
                    path: '', component: () => import('./Pages/Doramas/DoramaIndexPage.vue'),
                    name: 'doramas.index',
                },
                {
                    path: ':slug', component: () => import('./Pages/Doramas/DoramaShowPage.vue'),
                    name: 'doramas.show',
                    props: true
                },
            ],
        },
        {
            path: '/subscription', component: () => import('./Pages/MainPage.vue'),
            name: 'subscription'
        },
        //AUTH
        {
            path: '/auth',
            component: () => import('./Layouts/AuthLayout.vue'),
            meta: {
                // middleware: [auth],
            },
            children: [
                {
                    path: 'login', component: () => import('./Pages/Auth/LoginPage.vue'),
                    name: 'auth.login',
                    meta: {
                    //     middleware: [auth],
                    },
                },
                {
                    path: 'register', component: () => import('./Pages/Auth/RegisterPage.vue'),
                    name: 'auth.register',
                    meta: {
                    //     middleware: [auth],
                    },
                },
                {
                    path: 'forgot-password', component: () => import('./Pages/Auth/ForgotPasswordPage.vue'),
                    name: 'auth.password.request',
                    meta: {
                    //     middleware: [auth],
                    },
                },
                {
                    path: '/logout',
                    name: 'auth.logout',
                    beforeEnter: (to, from, next) => {
                        useAuthStore().logout();
                    },
                    meta: {
                    //     middleware: [auth],
                    },
                },
            ],
        },
        {   path: '/admin', component: () => { window.location.href = 'https://admin.reina.online' },
            name: 'admin'
        },
        // {   path: '/:pathMatch(.*)*', component: () => import('./Pages/MainPage.vue'),
        //     name: '404',
        //     redirect: "/"
        // }
    ]
})

export default router
