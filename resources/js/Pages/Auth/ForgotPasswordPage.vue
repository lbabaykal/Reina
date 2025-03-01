<script>
import AuthWindow from "../../Components/Login/AuthWindow.vue";
import axios from "axios";
import router from "../../router.js";
import GoogleLogoSvg from "../../Components/Svg/Auth/GoogleLogoSvg.vue";
import YandexLogoSvg from "../../Components/Svg/Auth/YandexLogoSvg.vue";
import VkLogoSvg from "../../Components/Svg/Auth/VkLogoSvg.vue";
import LoadingSvg from "../../Components/Svg/LoadingSvg.vue";

export default {
    name: "ForgotPasswordPage",
    components: {LoadingSvg, VkLogoSvg, YandexLogoSvg, GoogleLogoSvg, AuthWindow: AuthWindow},
    data() {
        return {
            email: null,
            response: null,
            errors: {},
            loading: false
        }
    },
    methods: {
        forgotPassword() {
            this.loading = true;
            this.errors = {};
            this.response = null;

            axios.post('/forgot-password', {
                email: this.email,
            })
            .then(response => {
                if (response.status === 200) {
                    this.response = response.data.status;
                }
                // router.push({name: "main"});
            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
                //TODO Уведомление что ошибка авторизации
            })
            .finally(() => {
                this.loading = false;
            });
        },
    },
}
</script>

<template>
    <AuthWindow>
        <div v-if="!loading" class="w-full text-center py-8 font-bold text-2xl text-green-500">
            Восстановление пароля
        </div>

        <loadingSvg v-if="loading"
                    classes="w-16 py-4 fill-green-500"
        />

        <div class="flex flex-col items-center text-black">
            <input
                class="w-80 border border-b-2 border-gray-300 py-1 rounded-sm focus:border-green-400 focus:ring-0"
                name="email"
                type="email"
                v-model="email"
                placeholder="Почта"
                required
            />

            <span v-if="errors.email"
                  class="w-90% pt-1 text-red-500 text-center"
            >
                {{ errors.email[0] }}
            </span>

            <span v-if="response"
                  class="w-90% pt-1 text-green-500 text-center"
            >
                {{ response }}
            </span>

            <button @click.prevent="forgotPassword"
                    class="px-10 py-1 my-5 font-bold text-lg text-white bg-green-700 hover:bg-green-600 rounded-md"
            >
                Восстановить пароль
            </button>
        </div>
    </AuthWindow>
</template>
