<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import StarSvg from '../../Svg/StarSvg.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';
import ToolTip from '../../ToolTip.vue';
import FavoriteSvg from '../../Svg/FavoriteSvg.vue';
import { useAuthStore } from '../../../Stores/authStore.js';
import { useFoldersStore } from '../../../Stores/foldersStore.js';
import { useFavoriteAnimeStore } from '../../../Stores/favoriteAnimeStore.js';
import SpinnerSvg from '../../Svg/SpinnerSvg.vue';

export default {
    name: 'Favorite',
    components: { SpinnerSvg, FavoriteSvg, ToolTip, ModalCloseButton, SuccessButton, WarningButton, DangerButton, StarSvg, LoadingSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            authStore: useAuthStore(),
            foldersStore: useFoldersStore().animeFolders,
            favoriteAnimeStore: useFavoriteAnimeStore,
            selectedFolderId: null,
            isFavoriteModalVisible: false,
        };
    },
    methods: {
        createOrUpdateAnimeFavorite() {
            this.favoriteAnimeStore.dataFavoriteLoading = true;
            axios
                .post(`/api/animes/favorite`, {
                    slug: this.slug,
                    folder_id: this.selectedFolderId,
                })
                .then((response) => {
                    this.favoriteAnimeStore.dataFavorite = response.data.data;
                    this.toggleFavoriteModal();
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.favoriteAnimeStore.dataFavoriteLoading = false;
                });
        },
        deleteAnimeFavorite() {
            this.favoriteAnimeStore.dataFavoriteLoading = true;
            axios
                .delete(`/api/animes/favorite/${this.favoriteAnimeStore.dataFavorite.id}`)
                .then((response) => {
                    this.favoriteAnimeStore.resetDataFavorite();
                    this.selectedFolderId = null;
                    this.toggleFavoriteModal();
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.favoriteAnimeStore.dataFavoriteLoading = false;
                });
        },
        toggleFavoriteModal() {
            if (this.authStore.isAuthenticated) {
                this.isFavoriteModalVisible = !this.isFavoriteModalVisible;
                this.selectedFolderId = this.favoriteAnimeStore.dataFavorite.folder_id;
            } else {
                push.error('Необходимо авторизоваться!');
            }
        },
    },
    computed: {
        isFavoriteDataLoading() {
            return this.favoriteAnimeStore.dataFavoriteLoading;
        },
        isFavoriteUser() {
            return this.favoriteAnimeStore.dataFavorite.folder_id !== null;
        },
    },
    mounted() {
        this.favoriteAnimeStore.getAnimeFavorite(this.slug);
    },
};
</script>

<template>
    <ToolTip
        message="В избранное"
        classes="py-2 px-4 bg-gray-600 text-red-500"
    >
        <button
            type="button"
            class="group flex cursor-pointer flex-row items-center rounded-sm bg-gray-700 p-2 hover:bg-gray-600"
            @click="toggleFavoriteModal"
            :disabled="isFavoriteDataLoading"
        >
            <SpinnerSvg
                v-if="isFavoriteDataLoading"
                classes="size-7 text-red-500"
            />
            <FavoriteSvg
                v-else
                :classes="['size-7 stroke-red-500 group-hover:fill-red-500', isFavoriteUser ? 'fill-red-500' : 'fill-transparent']"
            />
        </button>
    </ToolTip>

    <teleport to="#modals">
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
                <div class="max-w-96 min-w-80 rounded-md bg-white shadow-lg select-none dark:bg-black">
                    <div class="flex items-center justify-between border-b border-gray-400 p-2">
                        <div class="mx-auto truncate pl-8 text-xl font-semibold text-black dark:text-white">Избранное</div>
                        <ModalCloseButton @click="toggleFavoriteModal" />
                    </div>

                    <div class="relative space-y-1.5 p-3">
                        <div
                            class="absolute top-0 left-0 flex h-full w-full items-center justify-center bg-black/60"
                            v-if="isFavoriteDataLoading"
                        >
                            <LoadingSvg classes="w-20 fill-red-500" />
                        </div>

                        <label
                            v-for="folder in foldersStore"
                            class="flex cursor-pointer justify-start text-lg"
                        >
                            <input
                                :value="folder.id"
                                v-model="selectedFolderId"
                                type="radio"
                                class="peer hidden"
                            />
                            <span
                                class="bg-whiteActive dark:bg-blackActive flex-grow truncate rounded-md px-3 py-1 font-medium text-black peer-checked:bg-red-400 peer-checked:text-white hover:bg-black hover:text-white dark:text-white dark:hover:bg-white dark:hover:text-black"
                            >
                                {{ folder.name }}
                            </span>
                        </label>
                    </div>

                    <div class="flex justify-center border-t border-gray-400 p-2">
                        <WarningButton
                            v-if="isFavoriteUser"
                            @click="deleteAnimeFavorite"
                            :disabledButton="isFavoriteDataLoading"
                            class="mx-2"
                        />

                        <SuccessButton
                            @click="createOrUpdateAnimeFavorite"
                            :disabledButton="isFavoriteDataLoading"
                            class="mx-2"
                        />

                        <DangerButton
                            @click="toggleFavoriteModal"
                            :disabledButton="isFavoriteDataLoading"
                            class="mx-2"
                        />
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>
