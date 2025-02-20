<script>
import AuthWindow from "../../Components/Login/AuthWindow.vue";
import {useAuthStore} from "../../Stores/authStore.js";
import axios from "axios";
import router from "../../router.js";
import GoogleLogoSvg from "../../Components/Svg/Auth/GoogleLogoSvg.vue";
import YandexLogoSvg from "../../Components/Svg/Auth/YandexLogoSvg.vue";
import VkLogoSvg from "../../Components/Svg/Auth/VkLogoSvg.vue";
import LoadingSvg from "../../Components/Svg/LoadingSvg.vue";

export default {
    name: "RegisterPage",
    components: {LoadingSvg, VkLogoSvg, YandexLogoSvg, GoogleLogoSvg, AuthWindowComponent: AuthWindow},
    data() {
        return {
            name: null,
            email: null,
            password: null,
            password_confirmation: null,
            errors: {},
            authStore: useAuthStore(),
            loading: false
        }
    },
    methods: {
        register() {
            this.loading = true;
            axios.get("/sanctum/csrf-cookie")
                .then(() => {
                    axios.post('/register', {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    })
                        .then(response => {
                            router.push({name: "main"});
                        })
                        .catch(error => {
                            if (error.response.status === 422) {
                                console.log(error);
                                this.errors = error.response.data.errors;
                            }
                            //TODO Уведомление что ошибка
                        });
                })
                .catch(error => {
                    //TODO Уведомление что ошибка
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
}
</script>

<template>
    <AuthWindowComponent>
        <div v-if="!loading" class="w-full text-center py-8 font-bold text-2xl text-blue-500">
            Регистрации
        </div>

        <loadingSvg v-if="loading"
                    classes="w-16 py-4 fill-blue-500"
        />

        <div class="flex flex-col items-center text-black">
            <input
                class="w-80 border border-b-2 border-gray-300 py-1 rounded focus:border-blue-400 focus:ring-0"
                name="name"
                type="text"
                v-model="name"
                placeholder="Имя"
                required
            />

            <span v-if="errors.name"
                  class="w-90% pt-1 text-red-500 text-center"
            >
                {{ errors.name[0] }}
            </span>

            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-blue-400 focus:ring-0"
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

            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-blue-400 focus:ring-0"
                name="password"
                type="password"
                v-model="password"
                placeholder="Пароль"
                required
            />

            <input
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-blue-400 focus:ring-0"
                name="password_confirmation"
                type="password"
                v-model="password_confirmation"
                placeholder="Повторите пароль"
                required
            />

            <span v-if="errors.password"
                  class="w-90% pt-1 text-red-500 text-center"
            >
                {{ errors.password[0] }}
            </span>

            <button @click.prevent="register"
                    class="px-10 py-1 my-5 font-bold text-lg text-white bg-blue-700 hover:bg-blue-600 rounded-md"
            >
                Зарегистрироваться
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
    </AuthWindowComponent>
</template>
