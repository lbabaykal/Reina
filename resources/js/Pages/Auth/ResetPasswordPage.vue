<script>
import GoogleLogoSvg from "../../Components/Svg/Auth/GoogleLogoSvg.vue";
import AuthWindow from "../../Components/Login/AuthWindow.vue";
import YandexLogoSvg from "../../Components/Svg/Auth/YandexLogoSvg.vue";
import VkLogoSvg from "../../Components/Svg/Auth/VkLogoSvg.vue";
import axios from "axios";
import router from "../../router.js";

export default {
    name: "ResetPasswordPage",
    components: {VkLogoSvg, YandexLogoSvg, AuthWindow, GoogleLogoSvg},
    props: {
        token: String,
    },
    data() {
        return {
            email: null,
            password: null,
            password_confirmation: null,
            errors: {}
        }
    },
    methods: {
        resetPassword() {
            axios.post('/reset-password', {
                token: this.token,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            })
            .then(response => {
                router.push({name: "login"});
            })
            .catch(error => {
                if (error.response.status === 422) {
                    console.log(error);
                    this.errors = error.response.data.errors;
                }
                //TODO Уведомление что ошибка
            });
        },
    },
    mounted() {
        this.email = this.$route.query.email ? decodeURIComponent(this.$route.query.email) : null;
    }
}
</script>

<template>
    <AuthWindow>
        <div class="w-full text-center py-8 font-bold text-2xl text-violet-500">
            Сброс пароля
        </div>

        <div class="flex flex-col items-center text-black">
            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-violet-400 focus:ring-0"
                name="email"
                type="email"
                v-model="email"
                placeholder="Почта"
                required
            />

            <span v-if="errors.email"
                  class="w-90% pt-0.5 text-red-500 text-center"
            >
                {{ errors.email[0] }}
            </span>

            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-violet-400 focus:ring-0"
                name="password"
                type="password"
                v-model="password"
                placeholder="Пароль"
                required
            />

            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-violet-400 focus:ring-0"
                name="password_confirmation"
                type="password"
                v-model="password_confirmation"
                placeholder="Повторите пароль"
                required
            />

            <span v-if="errors.password"
                  class="w-90% pt-0.5 text-red-500 text-center"
            >
                {{ errors.password[0] }}
            </span>

            <button @click.prevent="resetPassword"
                    class="px-10 py-1 my-5 font-bold text-lg text-white bg-violet-700 hover:bg-violet-600 rounded-md"
            >
                Сбросить пароль
            </button>
        </div>
    </AuthWindow>
</template>
