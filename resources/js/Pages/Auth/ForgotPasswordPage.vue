<script>
import axios from 'axios';
import GoogleLogoSvg from '../../Components/Svg/Auth/GoogleLogoSvg.vue';
import YandexLogoSvg from '../../Components/Svg/Auth/YandexLogoSvg.vue';
import VkLogoSvg from '../../Components/Svg/Auth/VkLogoSvg.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';
import AuthWindow from '../../Components/Auth/AuthWindow.vue';

export default {
    name: 'ForgotPasswordPage',
    components: { LoadingSvg, VkLogoSvg, YandexLogoSvg, GoogleLogoSvg, AuthWindow },
    data() {
        return {
            email: null,
            errors: {},
            forgotPasswordLoading: true,
        };
    },
    methods: {
        forgotPassword() {
            this.forgotPasswordLoading = false;
            axios
                .post('/forgot-password', {
                    email: this.email,
                })
                .then((response) => {
                    // router.push({name: "login"});
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.forgotPasswordLoading = true;
                });
        },
    },
};
</script>

<template>
    <AuthWindow>
        <div class="w-full py-8 text-center text-2xl font-bold text-green-500">Восстановление пароля</div>

        <div class="flex flex-col items-center text-black">
            <input
                class="hover:bg-whiteFon w-80 rounded-sm border border-b-2 border-gray-300 px-1.5 py-1 duration-300 focus:border-green-400"
                name="email"
                type="email"
                v-model="email"
                placeholder="Почта"
                required
            />

            <span
                v-if="errors.email"
                class="w-90% mt-1 text-center text-red-500"
            >
                {{ errors.email[0] }}
            </span>

            <span
                v-if="errors.throttle"
                class="w-90% my-1 text-center text-red-500"
            >
                {{ errors.throttle[0] }}
            </span>

            <button
                @click="forgotPassword"
                class="relative my-4 cursor-pointer rounded-md bg-green-500 px-10 py-1 text-lg font-bold text-white hover:bg-green-600"
            >
                Восстановить пароль
                <span
                    v-if="!forgotPasswordLoading"
                    class="absolute top-0 left-0 flex w-full items-center justify-center rounded-md bg-green-500"
                >
                    <LoadingSvg classes="w-9 fill-white" />
                </span>
            </button>
        </div>
    </AuthWindow>
</template>
