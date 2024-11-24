<script>
import AuthWindow from "../../Components/Login/AuthWindow.vue";
import router from "../../router.js";
import {useAuthStore} from "../../Stores/authStore.js";

export default {
    name: "VerifyEmail",
    components: {AuthWindow},
    data() {
        return {
            response: false,
            errorsNotify: false,
            errorsVerify: false,
            id: null,
            hash: null,
            authStore: useAuthStore()
        }
    },
    methods: {
        sendVerifyNotification() {
            this.response = false;
            this.errors = false;
            axios.post('/email/verification-notification', {})
                .then(response => {
                    this.response = true;
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status === 429) {
                        this.errors = true;
                    }
                });
        },
        verifyEmail() {
            axios.get('/hash-verify-email', {
                params: {
                    id: this.authStore.user.id,
                    hash: this.hash,
                }
            })
                .then(response => {
                    console.log(response)
                    if (response.data.verified === true) {
                        router.push({name: 'index'});
                    }
                })
                .catch(error => {
                    console.log(error)
                    //TODO Уведомление
                });

        },
    },
}
</script>

<template>
    <AuthWindow>
        <div class="w-full text-center py-8 font-bold text-2xl text-orange-500">
            Подтверждение электронной почты
        </div>

        <div class="flex flex-col items-center text-black">
            <div class="text-center">
                На адрес электронной почты, указанный вами при регистрации, был отправлен код для подтверждения.
            </div>

            <span v-if="errorsNotify"
                  class="w-90% pt-1 text-red-500 text-center"
            >
                Слишком много попыток.<br>
                Подождите 5 минут и попробуйте снова.
            </span>
            <span v-if="response"
                  class="w-90% pt-1 text-green-500 text-center"
            >
                Новый код для подтверждения отправлен.
            </span>

            <input
                v-if="response"
                class="w-80 border border-b-2 border-gray-300 py-1 mt-4 rounded focus:border-rose-400 focus:ring-0"
                name="hash"
                type="text"
                v-model="hash"
                placeholder="Код"
                required
            />

            <span v-if="errorsVerify"
                  class="90% pt-1 text-red-500 text-center"
            >
                Неверный Код
            </span>

            <div class="flex flex-row items-center pt-10 pb-5">
                <button @click.prevent="sendVerifyNotification"
                        class="px-3 mx-2 py-2 font-bold text-white bg-orange-700 hover:bg-orange-600 rounded-md"
                >
                    Повторно отправить код
                </button>
                <button @click.prevent="verifyEmail"
                        class="px-3 mx-2 py-2 font-bold text-white bg-green-700 hover:bg-green-600 rounded-md"
                >
                    Подтвердить почту
                </button>
            </div>
        </div>
    </AuthWindow>
</template>
