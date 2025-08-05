<script>
import GoogleLogoSvg from '../../Components/Svg/Auth/GoogleLogoSvg.vue';
import YandexLogoSvg from '../../Components/Svg/Auth/YandexLogoSvg.vue';
import VkLogoSvg from '../../Components/Svg/Auth/VkLogoSvg.vue';
import axios from 'axios';
import router from '../../router.js';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import AuthWindow from '../../Components/Auth/AuthWindow.vue';

export default {
    name: 'ResetPasswordPage',
    components: { LoadingSvg, VkLogoSvg, YandexLogoSvg, AuthWindow, GoogleLogoSvg },
    props: {
        token: String,
    },
    data() {
        return {
            email: null,
            password: null,
            password_confirmation: null,
            errors: {},
            resetPasswordLoading: true,
        };
    },
    methods: {
        resetPassword() {
            this.resetPasswordLoading = false;
            axios
                .post('/reset-password', {
                    token: this.token,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((response) => {
                    router.push({ name: 'login' });
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.resetPasswordLoading = true;
                });
        },
    },
    mounted() {
        this.email = this.$route.query.email ? decodeURIComponent(this.$route.query.email) : null;
    },
};
</script>

<template>
    <AuthWindow>
        <div class="w-full py-8 text-center text-2xl font-bold text-violet-500">Сброс пароля</div>

        <div class="flex flex-col items-center text-black">
            <input
                class="hover:bg-whiteFon mt-4 w-80 rounded-sm border border-b-2 border-gray-300 px-1.5 py-1 duration-300 focus:border-violet-500"
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
                class="hover:bg-whiteFon mt-4 w-80 rounded-sm border border-b-2 border-gray-300 px-1.5 py-1 duration-300 focus:border-violet-500"
                name="password"
                type="password"
                v-model="password"
                placeholder="Пароль"
                required
            />

            <input
                class="hover:bg-whiteFon mt-4 w-80 rounded-sm border border-b-2 border-gray-300 px-1.5 py-1 duration-300 focus:border-violet-500"
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

            <span
                v-if="errors.throttle"
                class="w-90% my-1 text-center text-red-500"
            >
                {{ errors.throttle[0] }}
            </span>

            <button
                @click="resetPassword"
                class="relative my-4 cursor-pointer rounded-md bg-violet-500 px-10 py-1 text-lg font-bold text-white hover:bg-violet-600"
            >
                Сбросить пароль
                <span
                    v-if="!resetPasswordLoading"
                    class="absolute top-0 left-0 flex w-full items-center justify-center rounded-md bg-violet-500"
                >
                    <LoadingSvg classes="w-9 fill-white" />
                </span>
            </button>
        </div>
    </AuthWindow>
</template>
