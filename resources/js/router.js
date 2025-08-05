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
                    path: '', component: () => import('./Pages/Animes/IndexPage.vue'),
                    name: 'animes.index',
                },
                {
                    path: ':slug', component: () => import('./Pages/Animes/ShowPage.vue'),
                    name: 'animes.show',
                    props: true
                },
                {
                    path: ':slug/watch', component: () => import('./Pages/Animes/WatchPage.vue'),
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
                    path: '', component: () => import('./Pages/Doramas/IndexPage.vue'),
                    name: 'doramas.index',
                },
                {
                    path: ':slug', component: () => import('./Pages/Doramas/ShowPage.vue'),
                    name: 'doramas.show',
                    props: true
                },
                {
                    path: ':slug/watch', component: () => import('./Pages/Doramas/WatchPage.vue'),
                    name: 'doramas.watch',
                    props: true
                },
            ],
        },
        //  Account
        {
            path: '/account',
            component: () => import('./Layouts/MainLayout.vue'),
            meta: {
                middleware: [auth],
            },
            children: [
                {
                    path: 'profile',
                    component: () => import('./Pages/Account/ProfilePage.vue'),
                    name: 'account.profile',
                },
                {
                    path: 'settings',
                    redirect: '/account/settings/profile',
                    component: () => import('./Layouts/SettingsLayout.vue'),
                    name: 'account.settings',
                    children: [
                        {
                            path: 'profile',
                            component: () => import('./Pages/Account/Settings/ProfilePage.vue'),
                            name: 'account.settings.profile',
                        },
                        {
                            path: 'security',
                            component: () => import('./Pages/Account/Settings/SecurityPage.vue'),
                            name: 'account.settings.security',
                        }
                    ],
                },
                {
                    path: 'favorites',
                    children: [
                        {
                            path: '',
                            component: () => import('./Pages/Account/Favorites/IndexPage.vue'),
                            name: 'favorites.index',
                        },
                        {
                            path: 'animes',
                            component: () => import('./Pages/Account/Favorites/AnimesPage.vue'),
                            name: 'favorites.animes.index',
                        },
                        {
                            path: 'doramas',
                            component: () => import('./Pages/Account/Favorites/DoramasPage.vue'),
                            name: 'favorites.doramas.index',
                        },
                    ],
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
                    path: 'hash-verify-email/:id/:hash', component: () => import('./Pages/Auth/HashVerifyEmail.vue'),
                    name: 'verification.verify',
                    props: route => ({
                        id: route.params.id,
                        hash: route.params.hash,
                        expires: route.query.expires,
                        signature: route.query.signature,
                    }),
                    meta: {
                        middleware: [auth],
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
        {   path: '/admin', component: () => { window.location.href = 'http://admin.reina.online' },
            name: 'admin'
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        }

        return { top: 0, behavior: 'smooth' };
    }
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
