<script>
import CloseSvg from '../../Svg/CloseSvg.vue';
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import StarSvg from '../../Svg/StarSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';

export default {
    name: 'Favorite',
    components: { DangerButton, WarningButton, SuccessButton, StarSvg, LoadingSvg, CloseSvg },
    props: {
        doramaId: Number,
        dataUserForDorama: {
            rating: Number,
            favorite: {
                id: Number,
                title: String,
            },
        },
        isFavoriteUser: Boolean,
    },
    data() {
        return {
            dataUserFolders: {
                id: Number,
                title: String,
            },
            folder: 0,
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
                    this.dataUserFolders = response.data.folders;
                })
                .catch((error) => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        addDoramaFavorite() {
            this.dataLoading = true;
            axios
                .post(`/api/doramas/${this.doramaId}/favorite`, { folder: this.folder })
                .then((response) => {
                    this.dataUserForDorama.favorite.id = this.folder;
                    this.closeFavoriteModal();
                })
                .catch((error) => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        removeDoramaFavorite() {
            this.dataLoading = true;
            axios
                .delete(`/api/doramas/${this.doramaId}/favorite`)
                .then((response) => {
                    this.dataUserForDorama.favorite.id = 0;
                    this.closeFavoriteModal();
                })
                .catch((error) => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openFavoriteModal() {
            this.getDoramaFavorite();
            this.folder = this.dataUserForDorama.favorite.id;
            this.isFavoriteModalVisible = true;
        },
        closeFavoriteModal() {
            this.isFavoriteModalVisible = false;
        },
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
            <div class="shadow-modals max-w-136 min-w-120 rounded-md bg-black/80 select-none">
                <div class="flex items-center justify-between border-b p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Избранное</div>
                    <button
                        type="button"
                        @click="closeFavoriteModal"
                        class="inline-flex cursor-pointer items-center justify-center rounded-sm fill-white p-1 text-sm hover:bg-red-400 hover:fill-black hover:text-black"
                    >
                        <CloseSvg classes="size-6" />
                    </button>
                </div>

                <div
                    class="space-y-2 p-3"
                    v-if="!dataLoading"
                >
                    <div
                        class="w-full text-center text-lg"
                        v-if="!isFavoriteUser"
                    >
                        Вы не добавляли данное аниме в папку
                    </div>

                    <div class="flex flex-col items-center justify-center text-xl">
                        <div
                            v-for="dataFolder in dataUserFolders"
                            class="group flex max-w-96 min-w-64 bg-black text-white hover:bg-white hover:text-black"
                        >
                            <input
                                :id="dataFolder.id"
                                :value="dataFolder.id"
                                v-model="folder"
                                type="radio"
                                name="folder"
                                class="peer hidden"
                            />
                            <label
                                :for="dataFolder.id"
                                class="flex w-full cursor-pointer items-center justify-between p-1 peer-checked:bg-white peer-checked:text-black"
                            >
                                <span class="w-full truncate text-center">
                                    {{ dataFolder.title }}
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="flex h-32 items-center justify-center"
                >
                    <LoadingSvg classes="w-20 fill-red-500" />
                </div>

                <div class="flex justify-center border-t border-gray-200 p-3">
                    <WarningButton
                        v-if="isFavoriteUser"
                        @click="removeDoramaFavorite"
                        text="Удалить"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <SuccessButton
                        @click="addDoramaFavorite"
                        :text="!isFavoriteUser ? 'Добавить' : 'Изменить'"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <DangerButton
                        @click="closeFavoriteModal"
                        text="Отмена"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />
                </div>
            </div>
        </div>
    </transition>
</template>
