<script>

import AuthWindow from "../../Components/Login/AuthWindow.vue";
import GoogleLogoSvg from "../../Components/Svg/Auth/GoogleLogoSvg.vue";
import VkLogoSvg from "../../Components/Svg/Auth/VkLogoSvg.vue";
import YandexLogoSvg from "../../Components/Svg/Auth/YandexLogoSvg.vue";
import {useAuthStore} from "../../Stores/authStore.js";
import axios from "axios";
import router from "../../router.js";
import AuthLayout from "../../Layouts/AuthLayout.vue";

export default {
    name: "LoginPage",
    components: {AuthLayout, YandexLogoSvg, VkLogoSvg, GoogleLogoSvg, AuthWindow: AuthWindow},
    data() {
        return {
            email: null,
            password: null,
            errors: {},
            authStore: useAuthStore(),
        }
    },
    methods: {
        login() {
            axios.get("/sanctum/csrf-cookie")
                .then(() => {
                    axios.post('/login', {
                        email: this.email,
                        password: this.password
                    })
                        .then(response => {
                            router.push({name: "main"});
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors;
                            }
                            //TODO Уведомление что ошибка
                        });
                })
                .catch(error => {
                    //TODO Уведомление что ошибка
                });
        },
    },
}
</script>

<template>
    <AuthWindow>
        <div class="w-full text-center py-8 font-bold text-2xl text-rose-500">
            Авторизация
        </div>

        <div class="flex flex-col items-center text-black">
            <input
                class="w-80 border border-b-2 border-gray-300 py-1 rounded focus:border-rose-400 focus:ring-0"
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
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-rose-400 focus:ring-0"
                name="password"
                type="password"
                v-model="password"
                placeholder="Пароль"
                required
            />

            <span v-if="errors.password"
                  class="90% pt-0.5 text-red-500 text-center"
            >
                {{ errors.password[0] }}
            </span>

            <button @click.prevent="login"
                    class="px-10 py-1 my-5 font-bold text-lg text-white bg-rose-700 hover:bg-rose-600 rounded-md"
            >
                Войти
            </button>

            <div class="w-full flex items-center text-black justify-around">
                <hr class="w-40 h-0.5 bg-neutral-400"/>
                <div class="px-6">или</div>
                <hr class="w-40 h-0.5 bg-neutral-400"/>
            </div>

            <div class="flex flex-row py-5">
                <GoogleLogoSvg classes="w-10 h-10 mx-4"/>
                <VkLogoSvg classes="w-10 h-10 mx-4"/>
                <YandexLogoSvg classes="w-10 h-10 mx-4"/>
            </div>
        </div>
    </AuthWindow>
</template>
