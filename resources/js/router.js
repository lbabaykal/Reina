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
                    path: 'search', component: () => import('./Pages/SearchPage.vue'),
                    name: 'search'
                },
                {
                    path: '/subscription', component: () => import('./Pages/MainPage.vue'),
                    name: 'subscription'
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
        //AUTH
        {
            path: '/',
            component: () => import('./Layouts/AuthLayout.vue'),
            meta: {
                // middleware: [auth],
            },
            children: [
                {
                    path: 'login', component: () => import('./Pages/Auth/LoginPage.vue'),
                    name: 'login',
                    meta: {
                    },
                },
                {
                    path: 'register', component: () => import('./Pages/Auth/RegisterPage.vue'),
                    name: 'register',
                    meta: {
                    },
                },
                {
                    path: 'verify-email', component: () => import('./Pages/Auth/VerifyEmail.vue'),
                    name: 'verification.notice',
                    meta: {
                    },
                },
                {
                    path: 'forgot-password', component: () => import('./Pages/Auth/ForgotPasswordPage.vue'),
                    name: 'password.request',
                    meta: {
                    },
                },
                {
                    path: 'reset-password/:token', component: () => import('./Pages/Auth/ResetPasswordPage.vue'),
                    name: 'password.reset',
                    props: true,
                    meta: {
                    },
                },
                {
                    path: 'logout',
                    name: 'logout',
                    beforeEnter: (to, from, next) => {
                        useAuthStore().logout();
                    },
                    meta: {
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
