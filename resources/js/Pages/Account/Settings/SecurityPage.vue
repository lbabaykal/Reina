<script>
import axios from 'axios';
import { push } from 'notivue';
import LoadingSvg from '../../../Components/Svg/LoadingSvg.vue';

export default {
    name: 'SecurityPage',
    components: { LoadingSvg },
    data() {
        return {
            current_password: null,
            password: null,
            password_confirmation: null,
            passwordLoading: true,
            errorsPassword: [],
        };
    },
    methods: {
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
    },
};
</script>

<template>
    <div class="w-240">
        <div class="h-full w-1/2 space-y-2.5 rounded-md bg-white p-3 text-black dark:bg-black dark:text-white">
            <div class="mb-1 text-lg font-semibold">Смена пароля</div>

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
                    v-if="passwordLoading"
                    @click="updatePassword"
                    class="h-8 w-26 cursor-pointer rounded-md bg-sky-400 text-white"
                >
                    Сохранить
                </button>
                <div
                    v-else
                    class="flex h-8 w-26 items-center justify-center rounded-md bg-sky-400"
                >
                    <LoadingSvg classes="w-8 fill-white" />
                </div>
            </div>
        </div>
    </div>
</template>
