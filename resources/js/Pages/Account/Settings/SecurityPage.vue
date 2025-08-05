<script>
import axios from 'axios';
import { push } from 'notivue';
import LoadingSvg from '../../../Components/Svg/LoadingSvg.vue';
import { useAuthStore } from '../../../Stores/authStore.js';
import CheckSvg from '../../../Components/Svg/CheckSvg.vue';
import ExclamationMarkSvg from '../../../Components/Svg/ExclamationMarkSvg.vue';

export default {
    name: 'SecurityPage',
    components: { ExclamationMarkSvg, CheckSvg, LoadingSvg },
    data() {
        return {
            authStore: useAuthStore(),
            userData: {},
            current_password: null,
            password: null,
            password_confirmation: null,
            passwordLoading: true,
            verifyEmailLoading: true,
            userDataLoading: true,
            errorsPassword: [],
            errorsVerifyEmail: [],
        };
    },
    methods: {
        getUserData() {
            this.userDataLoading = false;
            axios
                .get('/api/user-data-all')
                .then((response) => {
                    this.userData = response.data.user;
                    console.log(this.userData.name);
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.userDataLoading = true;
                });
        },
        updatePassword() {
            this.passwordLoading = false;
            axios
                .post('/change-password', {
                    current_password: this.current_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then((response) => {
                    push.success(response.data);
                    this.current_password = null;
                    this.password = null;
                    this.password_confirmation = null;
                    this.errorsPassword = [];
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errorsPassword = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.passwordLoading = true;
                });
        },
        verifyEmail() {
            this.verifyEmailLoading = false;
            axios
                .post('/email/verification-notification')
                .then((response) => {
                    push.success(response.data);
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errorsVerifyEmail = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.verifyEmailLoading = true;
                });
        },
    },
    mounted() {
        this.getUserData();
    },
};
</script>

<template>
    <div class="w-240">
        <div
            v-if="userDataLoading"
            class="flex flex-row space-y-5 space-x-5"
        >
            <div class="h-full w-1/2 space-y-2.5 rounded-md bg-white p-3 text-black dark:bg-black dark:text-white">
                <div class="mb-1.5 text-lg font-semibold">Смена пароля</div>

                <div class="flex flex-col">
                    <label
                        for="current_password"
                        class="mb-1.5"
                    >
                        Текущий пароль
                    </label>

                    <span
                        v-if="errorsPassword.current_password"
                        class="mb-1.5 text-red-500"
                    >
                        {{ errorsPassword.current_password[0] }}
                    </span>

                    <input
                        id="current_password"
                        type="password"
                        v-model="current_password"
                        required
                        class="hover:bg-whiteFon focus:bg-whiteFon dark:hover:bg-blackSimple dark:focus:bg-blackSimple w-2/3 rounded-md border border-gray-500 px-2 py-1 duration-300"
                    />
                </div>

                <div class="flex flex-col">
                    <label
                        for="password"
                        class="mb-1.5"
                    >
                        Пароль
                    </label>

                    <span
                        v-if="errorsPassword.password"
                        class="mb-1.5 text-red-500"
                    >
                        {{ errorsPassword.password[0] }}
                    </span>

                    <input
                        id="password"
                        type="password"
                        v-model="password"
                        required
                        class="hover:bg-whiteFon focus:bg-whiteFon dark:hover:bg-blackSimple dark:focus:bg-blackSimple w-2/3 rounded-md border border-gray-500 px-2 py-1 duration-300"
                    />
                </div>

                <div class="flex flex-col">
                    <label
                        for="password_confirmation"
                        class="mb-1.5"
                    >
                        Подтверждение пароля
                    </label>

                    <span
                        v-if="errorsPassword.password_confirmation"
                        class="mb-1.5 text-red-500"
                    >
                        {{ errorsPassword.password_confirmation[0] }}
                    </span>

                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="password_confirmation"
                        required
                        class="hover:bg-whiteFon focus:bg-whiteFon dark:hover:bg-blackSimple dark:focus:bg-blackSimple w-2/3 rounded-md border border-gray-500 px-2 py-1 duration-300"
                    />
                </div>

                <div>
                    <button
                        @click="updatePassword"
                        class="relative cursor-pointer rounded-md bg-sky-500 px-3 py-1.5 text-white hover:bg-sky-600 duration-300"
                    >
                        Сохранить
                        <span
                            v-if="!passwordLoading"
                            class="absolute top-0 left-0 flex w-full items-center justify-center rounded-md bg-sky-500"
                        >
                            <LoadingSvg classes="w-7 fill-white" />
                        </span>
                    </button>
                </div>
            </div>

            <div class="h-full w-1/2 space-y-2.5 rounded-md bg-white p-3 text-black dark:bg-black dark:text-white">
                <div class="mb-1.5 text-lg font-semibold">Подтверждение электронной почты</div>

                <div class="flex flex-col">
                    <label
                        for="email"
                        class="mb-1.5"
                    >
                        Электронный почта
                    </label>

                    <span
                        v-if="errorsVerifyEmail.email"
                        class="mb-1.5 text-red-500"
                    >
                        {{ errorsVerifyEmail.email[0] }}
                    </span>

                    <input
                        id="email"
                        type="text"
                        v-model="userData.email"
                        disabled
                        class="hover:bg-whiteFon focus:bg-whiteFon dark:hover:bg-blackSimple dark:focus:bg-blackSimple w-2/3 rounded-md border border-gray-500 px-2 py-1 duration-300"
                    />
                </div>

                <div
                    v-if="this.userData.email_verified_at !== null"
                    class="flex flex-row items-center text-lime-500"
                >
                    <CheckSvg classes="size-6 mr-1" />
                    Ваша электронная почта подтверждена.
                </div>

                <div v-else>
                    <div class="mb-2.5 flex flex-row items-center text-red-500">
                        <ExclamationMarkSvg classes="size-6 mr-1" />
                        Ваша электронная почта не подтверждена.
                    </div>
                    <button
                        @click="verifyEmail"
                        class="relative cursor-pointer rounded-md bg-sky-500 px-3 py-1.5 text-white hover:bg-sky-600 duration-300"
                    >
                        Подтвердить
                        <span
                            v-if="!verifyEmailLoading"
                            class="absolute top-0 left-0 flex w-full items-center justify-center rounded-md bg-sky-500"
                        >
                            <LoadingSvg classes="w-7 fill-white" />
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <section
            v-else
            class="flex h-128 items-center justify-center"
        >
            <LoadingSvg classes="w-20 fill-rose-500" />
        </section>
    </div>
</template>
