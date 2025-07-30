<script>
import { useAuthStore } from '../../../Stores/authStore.js';
import LoadingSvg from '../../../Components/Svg/LoadingSvg.vue';
import CloudUploadSvg from '../../../Components/Svg/CloudUploadSvg.vue';
import TrashSvg from '../../../Components/Svg/TrashSvg.vue';
import axios from 'axios';
import { push } from 'notivue';
import AvatarImage from '../../../Components/Image/AvatarImage.vue';

export default {
    name: 'ProfilePage',
    components: { AvatarImage, TrashSvg, CloudUploadSvg, LoadingSvg },
    data() {
        return {
            avatar: null,
            name: null,
            errors: {},
            authStore: useAuthStore(),
            userDataLoading: false,
            userDataUpdateLoading: true,

            selectedNewAvatar: null,
            previewAvatar: null,
        };
    },
    methods: {
        async getUserData() {
            this.userDataLoading = false;
            await this.authStore.getUser();
            this.avatar = this.authStore.user.avatar;
            this.name = this.authStore.user.name;
            this.userDataLoading = true;
        },
        updateUserData() {
            this.userDataUpdateLoading = false;
            axios
                .post(
                    '/update-profile',
                    {
                        avatar: this.selectedNewAvatar,
                        name: this.name,
                    },
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        },
                    },
                )
                .then((response) => {
                    push.success(response.data);
                    this.getUserData();
                    this.previewAvatar = null;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.userDataUpdateLoading = true;
                });
        },
        clearNewAvatarAndPreview() {
            this.selectedNewAvatar = null;
            this.previewAvatar = null;
        },
        onFileChange(event) {
            const file = event.target.files[0];

            if (file && file.type.startsWith('image/')) {
                this.selectedNewAvatar = file;

                const reader = new FileReader();
                reader.onload = (event) => {
                    this.previewAvatar = event.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.selectedNewAvatar = null;
                this.previewAvatar = null;
            }
        },
    },
    mounted() {
        this.getUserData();
    },
};
</script>

<template>
    <section class="w-240">
        <div
            v-if="userDataLoading"
            class="flex flex-col space-y-5 space-x-5"
        >
            <div class="flex space-x-5">
                <div class="flex min-h-28 w-1/2 flex-col rounded-md bg-white p-3 text-black dark:bg-black dark:text-white">
                    <div class="mb-2.5 text-lg leading-none font-semibold">Аватар</div>
                    <div class="flex flex-row justify-between">
                        <div>
                            <label
                                for="avatar"
                                class="hover:bg-whiteSimple dark:hover:bg-blackSimple flex size-30 cursor-pointer items-center justify-center overflow-hidden rounded-md border-2 border-dashed border-gray-500"
                            >
                                <CloudUploadSvg classes="size-12" />
                            </label>

                            <input
                                id="avatar"
                                type="file"
                                accept="image/png, image/jpeg, image/webp"
                                @change="onFileChange"
                                hidden
                            />
                        </div>

                        <div>
                            <div
                                v-if="previewAvatar"
                                class="relative size-30 overflow-hidden rounded-md border-1 border-gray-500"
                            >
                                <img
                                    :src="previewAvatar"
                                    alt=""
                                    class="size-full object-cover object-center"
                                />

                                <div
                                    @click="clearNewAvatarAndPreview"
                                    class="absolute top-1 right-1 cursor-pointer rounded-md bg-black/60 p-1 hover:bg-red-500/80"
                                >
                                    <TrashSvg classes="size-5 fill-white text-black" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="size-30 shrink-0 overflow-hidden rounded-md">
                                <AvatarImage
                                    :avatar="this.avatar"
                                    class="rounded-md border border-gray-500"
                                />
                            </div>
                        </div>
                    </div>

                    <span
                        v-if="errors.avatar"
                        class="w-90% pt-1 text-center text-red-500"
                    >
                        {{ errors.avatar[0] }}
                    </span>
                </div>

                <div class="h-full w-1/2 rounded-md bg-white p-3 text-black dark:bg-black dark:text-white">
                    <div class="mb-1 text-lg font-semibold">Имя</div>
                    <input
                        type="text"
                        v-model="name"
                        required
                        class="hover:bg-whiteFon focus:bg-whiteFon dark:hover:bg-blackSimple dark:focus:bg-blackSimple w-2/3 rounded-md border border-gray-500 px-2 py-1 duration-300"
                    />
                    <span
                        v-if="errors.name"
                        class="w-90% pt-1 text-center text-red-500"
                    >
                        {{ errors.name[0] }}
                    </span>
                </div>
            </div>

            <div class="flex w-full items-center justify-center">
                <button
                    v-if="userDataUpdateLoading"
                    @click="updateUserData"
                    class="h-8 w-26 cursor-pointer rounded-md bg-lime-500 text-white hover:bg-lime-600"
                >
                    Сохранить
                </button>

                <div
                    v-else
                    class="flex h-8 w-26 items-center justify-center rounded-md bg-lime-400"
                >
                    <LoadingSvg classes="w-8 fill-white" />
                </div>
            </div>
        </div>

        <section
            v-else
            class="flex h-128 items-center justify-center"
        >
            <LoadingSvg classes="w-20 fill-rose-500" />
        </section>
    </section>
</template>
