<script>
import AuthWindow from '../../Components/Login/AuthWindow.vue';
import { useAuthStore } from '../../Stores/authStore.js';
import axios from 'axios';
import router from '../../router.js';
import GoogleLogoSvg from '../../Components/Svg/Auth/GoogleLogoSvg.vue';
import YandexLogoSvg from '../../Components/Svg/Auth/YandexLogoSvg.vue';
import VkLogoSvg from '../../Components/Svg/Auth/VkLogoSvg.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import { push } from 'notivue';

export default {
    name: 'RegisterPage',
    components: { LoadingSvg, VkLogoSvg, YandexLogoSvg, GoogleLogoSvg, AuthWindowComponent: AuthWindow },
    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            errors: {},
            authStore: useAuthStore(),
            loading: false,
        };
    },
    methods: {
        register() {
            this.loading = true;
            axios
                .get('/sanctum/csrf-cookie')
                .then(() => {
                    axios
                        .post('/register', {
                            name: this.name,
                            email: this.email,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        })
                        .then((response) => {
                            router.push({ name: 'main' });
                        })
                        .catch((error) => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                        });
                })
                .catch((error) => {})
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>

<template>
    <AuthWindowComponent>
        <div
            v-if="!loading"
            class="w-full py-8 text-center text-2xl font-bold text-blue-500"
        >
            Регистрации
        </div>

        <loadingSvg
            v-if="loading"
            classes="w-16 py-4 fill-blue-500"
        />

        <div class="flex flex-col items-center text-black">
            <input
                class="w-80 rounded-sm border border-b-2 border-gray-300 py-1 focus:border-blue-400 focus:ring-0"
                name="name"
                type="text"
                v-model="name"
                placeholder="Имя"
                required
            />

            <span
                v-if="errors.name"
                class="w-90% pt-1 text-center text-red-500"
            >
                {{ errors.name[0] }}
            </span>

            <input
                class="mt-4 w-80 rounded-sm border border-b-2 border-gray-300 py-1 focus:border-blue-400 focus:ring-0"
                name="email"
                type="email"
                v-model="email"
                placeholder="Почта"
                required
            />

            <span
                v-if="errors.email"
                class="w-90% pt-1 text-center text-red-500"
            >
                {{ errors.email[0] }}
            </span>

            <input
                class="mt-4 w-80 rounded-sm border border-b-2 border-gray-300 py-1 focus:border-blue-400 focus:ring-0"
                name="password"
                type="password"
                v-model="password"
                placeholder="Пароль"
                required
            />

            <input
                class="mt-4 w-80 rounded-sm border border-b-2 border-gray-300 py-1 focus:border-blue-400 focus:ring-0"
                name="password_confirmation"
                type="password"
                v-model="password_confirmation"
                placeholder="Повторите пароль"
                required
            />

            <span
                v-if="errors.password"
                class="w-90% pt-1 text-center text-red-500"
            >
                {{ errors.password[0] }}
            </span>

            <button
                @click.prevent="register"
                class="my-5 rounded-md bg-blue-700 px-10 py-1 text-lg font-bold text-white hover:bg-blue-600"
            >
                Зарегистрироваться
            </button>

            <div class="flex w-full items-center justify-around text-black">
                <hr class="h-0.5 w-40 bg-neutral-400" />
                <div class="px-6">или</div>
                <hr class="h-0.5 w-40 bg-neutral-400" />
            </div>

            <div class="flex flex-row py-5">
                <GoogleLogoSvg classes="w-10 h-10 mx-4" />
                <VkLogoSvg classes="w-10 h-10 mx-4" />
                <YandexLogoSvg classes="w-10 h-10 mx-4" />
            </div>
        </div>
    </AuthWindowComponent>
</template>
