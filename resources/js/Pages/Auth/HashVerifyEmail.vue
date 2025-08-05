<script>
import router from '../../router.js';
import AuthWindow from '../../Components/Auth/AuthWindow.vue';
import LoadingSvg from '../../Components/Svg/LoadingSvg.vue';

export default {
    name: 'HashVerifyEmail',
    components: { LoadingSvg, AuthWindow },
    props: {
        id: String,
        hash: String,
        expires: String,
        signature: String,
    },
    data() {
        return {
            errors: {},
            verifySuccessfully: false,
            verifyEmailLoading: false,
        };
    },
    methods: {
        verifyEmail() {
            this.verifyEmailLoading = false;
            axios
                .post(
                    `/hash-verify-email/${this.id}/${this.hash}`,
                    {},
                    {
                        params: {
                            expires: this.expires,
                            signature: this.signature,
                        },
                    },
                )
                .then((response) => {
                    this.verifySuccessfully = true;
                    setTimeout(() => {
                        router.push({ name: 'main' });
                    }, 3000);
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                    if (error.response.status === 429) {
                        this.errors.throttle = 'Слишком много запросов.';
                    }
                })
                .finally(() => {
                    this.verifyEmailLoading = true;
                });
        },
    },
    mounted() {
        this.verifyEmail();
    },
};
</script>

<template>
    <AuthWindow>
        <div class="w-full py-8 text-center text-2xl font-bold text-orange-500">Подтверждение электронной почты</div>

        <div class="flex flex-col items-center text-black w-full p-5">
            <div
                v-if="!verifyEmailLoading"
                class="mb-5 flex flex-row items-center"
            >
                <LoadingSvg classes="size-20 fill-orange-500" />
            </div>

            <div v-if="verifyEmailLoading && verifySuccessfully"
            class="w-90% text-center text-lime-500"
            >
                Ваш электронный адрес подтверждён.
            </div>

            <span
                v-if="errors.email"
                class="w-90% text-center text-red-500"
            >
                {{ errors.email[0] }}
            </span>

            <span
                v-if="errors.throttle"
                class="w-90% text-center text-red-500"
            >
                {{ errors.throttle }}
            </span>
        </div>
    </AuthWindow>
</template>
