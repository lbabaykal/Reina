<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import StarSvg from '../../Svg/StarSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';

export default {
    name: 'Favorite',
    components: { ModalCloseButton, DangerButton, WarningButton, SuccessButton, StarSvg, LoadingSvg },
    props: {
        doramaId: Number,
        dataUserForDorama: {
            rating: Number,
            favorite: {
                folder_id: Number,
                episode: Number,
            },
        },
        isFavoriteUser: Boolean,
    },
    data() {
        return {
            dataFoldersUser: {
                folder_id: Number,
                episode: Number,
            },
            folder_id: 0,
            dataLoading: false,
            isFavoriteModalVisible: false,
        };
    },
    methods: {
        getDoramaFavorite() {
            this.dataLoading = true;
            axios
                .post('/api/doramas/favorite')
                .then((response) => {
                    this.dataFoldersUser = response.data.folders;
                })
                .catch((error) => {
                    push.error(error.response.data.message);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        addOrUpdateDoramaFavorite() {
            this.dataLoading = true;
            if (!this.isFavoriteUser) {
                axios
                    .post(`/api/doramas/${this.doramaId}/favorite`, { folder_id: this.folder_id })
                    .then((response) => {
                        this.dataUserForDorama.favorite = response.data.favorite;
                        push.success(response.data.message);
                        this.closeFavoriteModal();
                    })
                    .catch((error) => {
                        push.error(error.response.data.message);
                    })
                    .finally(() => {
                        this.dataLoading = false;
                    });
            } else {
                axios
                    .patch(`/api/doramas/${this.doramaId}/favorite`, { folder_id: this.folder_id })
                    .then((response) => {
                        this.dataUserForDorama.favorite.folder_id = this.folder_id;
                        push.success(response.data.message);
                        this.closeFavoriteModal();
                    })
                    .catch((error) => {
                        push.error(error.response.data.message);
                    })
                    .finally(() => {
                        this.dataLoading = false;
                    });
            }
        },
        deleteDoramaFavorite() {
            this.dataLoading = true;
            axios
                .delete(`/api/doramas/${this.doramaId}/favorite`)
                .then((response) => {
                    this.dataUserForDorama.favorite = {
                        folder_id: 0,
                        episode: 0,
                    };
                    push.success(response.data.message);
                    this.closeFavoriteModal();
                })
                .catch((error) => {
                    push.error(error.response.data.message);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openFavoriteModal() {
            this.folder_id = this.dataUserForDorama.favorite.folder_id;
            this.isFavoriteModalVisible = true;
        },
        closeFavoriteModal() {
            this.isFavoriteModalVisible = false;
        },
    },
    mounted() {
        this.getDoramaFavorite();
    },
};
</script>

<template>
    <transition
        enter-active-class="transition-all ease-in-out duration-300"
        enter-from-class="opacity-0 translate-y-10 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition-all ease-in-out duration-300"
        leave-from-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-10 scale-95"
    >
        <div
            v-if="isFavoriteModalVisible"
            class="fixed top-0 left-0 z-40 flex h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto"
        >
            <div class="shadow-modals max-w-96 min-w-80 rounded-md bg-black/80 select-none">
                <div class="flex items-center justify-between border-b border-gray-400 p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Избранное</div>
                    <ModalCloseButton @click="closeFavoriteModal" />
                </div>

                <div class="relative space-y-1.5 p-3">
                    <div
                        class="absolute top-0 left-0 flex h-full w-full items-center justify-center bg-black/60"
                        v-if="dataLoading"
                    >
                        <LoadingSvg classes="w-20 fill-violet-500" />
                    </div>

                    <label
                        v-for="dataFolder in dataFoldersUser"
                        class="flex cursor-pointer justify-start text-lg"
                    >
                        <input
                            :value="dataFolder.id"
                            v-model="folder_id"
                            type="radio"
                            class="peer hidden"
                        />
                        <span
                            class="bg-blackActive/70 flex-grow truncate rounded-md px-3 py-1 font-medium peer-checked:bg-white peer-checked:text-black hover:bg-violet-500/80 hover:text-white"
                        >
                            {{ dataFolder.title }}
                        </span>
                    </label>
                </div>

                <div class="flex justify-center border-t border-gray-400 p-2">
                    <WarningButton
                        v-if="isFavoriteUser"
                        @click="deleteDoramaFavorite"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <SuccessButton
                        @click="addOrUpdateDoramaFavorite"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <DangerButton
                        @click="closeFavoriteModal"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />
                </div>
            </div>
        </div>
    </transition>
</template>
