import { createRouter, createWebHistory } from 'vue-router'
import {useAuthStore} from "./Stores/authStore.js";
import middlewarePipeline from "../Middleware/middlewarePipeline.js";
import auth from "../Middleware/auth.js";
import guest from "../Middleware/guest.js";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import('./Layouts/MainLayout.vue'),
            children: [
                {
                    path: '', component: () => import('./Pages/MainPage.vue'),
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
                {
                    path: '/:pathMatch(.*)*', component: () => import('./Pages/NotFoundPage.vue'),
                    name: '404',
                }
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
                {
                    path: ':slug/watch', component: () => import('./Pages/Animes/AnimeWatchPage.vue'),
                    name: 'animes.watch',
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
                {
                    path: ':slug', component: () => import('./Pages/Doramas/DoramaShowPage.vue'),
                    name: 'doramas.watch',
                    props: true
                },
            ],
        },
        //AUTH
        {
            path: '/',
            component: () => import('./Layouts/AuthLayout.vue'),
            meta: {
                middleware: [auth],
            },
            children: [
                {
                    path: 'login', component: () => import('./Pages/Auth/LoginPage.vue'),
                    name: 'login',
                    meta: {
                        middleware: [guest],
                    },
                },
                {
                    path: 'register', component: () => import('./Pages/Auth/RegisterPage.vue'),
                    name: 'register',
                    meta: {
                        middleware: [guest],
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
                        middleware: [guest],
                    },
                },
                {
                    path: 'reset-password/:token', component: () => import('./Pages/Auth/ResetPasswordPage.vue'),
                    name: 'password.reset',
                    props: true,
                    meta: {
                        middleware: [guest],
                    },
                },
                {
                    path: 'logout',
                    name: 'logout',
                    beforeEnter: () => {
                        useAuthStore().logout();
                    },
                    meta: {
                        middleware: [auth],
                    },
                },
            ],
        },
        {   path: '/admin', component: () => { window.location.href = 'https://admin.reina.online' },
            name: 'admin'
        },
    ]
});

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next();
    }

    const middleware = to.meta.middleware;
    const context = { to, from, next };

    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    });
});

export default router
