<script>
import TrashSvg from "../../../Components/Svg/TrashSvg.vue";
import CloseSvg from "../../../Components/Svg/CloseSvg.vue";
import SendSvg from "../../../Components/Svg/SendSvg.vue";
import LoadingSvg from "../../../Components/Svg/LoadingSvg.vue";
import StarSvg from "../../../Components/Svg/StarSvg.vue";

export default {
    name: "Favorite",
    components: {StarSvg, LoadingSvg, SendSvg, CloseSvg, TrashSvg},
    props: {
        animeId: Number,
        dataUserForAnime: {
            rating: Number,
            favorite: {
                id: Number,
                title: String,
            },
        },
        isFavorite: Boolean,
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
        }
    },
    methods: {
        getAnimeFavorite() {
            this.dataLoading = true;
            axios.post('/api/animes/favorite')
                .then(response => {
                    this.dataUserFolders = response.data.folders;
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        addAnimeFavorite() {
            this.dataLoading = true;
            axios.post(`/api/animes/${this.animeId}/favorite`, { folder: this.folder })
                .then(response => {
                    this.dataUserForAnime.favorite.id = this.folder;
                    this.closeFavoriteModal();
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        removeAnimeFavorite() {
            this.dataLoading = true;
            axios.delete(`/api/animes/${this.animeId}/favorite`)
                .then(response => {
                    this.dataUserForAnime.favorite.id = 0;
                    this.closeFavoriteModal();
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openFavoriteModal() {
            this.getAnimeFavorite();
            this.folder = this.dataUserForAnime.favorite.id;
            this.isFavoriteModalVisible = true;
        },
        closeFavoriteModal() {
            this.isFavoriteModalVisible = false;
        },
    },
}
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
        <div v-if="isFavoriteModalVisible"
             class="overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-40 flex justify-center items-center w-full h-full"
        >
            <div class="bg-black/75 rounded select-none shadow-modals min-w-120 max-w-136">
                <div class="flex items-center justify-between p-2 border-b rounded-t">
                    <div class="text-xl text-white truncate pl-8 mx-auto">
                        Избранное
                    </div>
                    <button type="button"
                            @click="closeFavoriteModal"
                            class="hover:bg-red-400 hover:text-black fill-white hover:fill-black text-sm p-1 inline-flex justify-center items-center">
                        <CloseSvg classes="size-6"/>
                    </button>
                </div>

                    <div class="p-2 space-y-2"
                         v-if="!dataLoading"
                    >
                        <div class="w-full text-center text-lg"
                             v-if="!isFavorite"
                        >
                            Вы не добавляли данное аниме в папку
                        </div>

                        <div class="flex flex-col justify-center items-center text-xl">
                            <div v-for="dataFolder in dataUserFolders"
                                class="group flex min-w-64 max-w-96 my-1 bg-black hover:bg-white text-white hover:text-black"
                            >
                                <input :id="dataFolder.id"
                                       :value="dataFolder.id"
                                       v-model="folder"
                                       type="radio"
                                       name="folder"
                                       class="hidden peer"
                                />
                                <label :for="dataFolder.id"
                                       class="flex items-center justify-between w-full p-2 cursor-pointer peer-checked:bg-white peer-checked:text-black"
                                >
                                    <span class="w-full text-center truncate">
                                        {{ dataFolder.title }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div v-else
                         class="flex items-center justify-center h-32"
                    >
                        <LoadingSvg classes="w-20 fill-red-500"/>
                    </div>

                    <div class="flex justify-center p-3 border-t border-gray-200 rounded-b">
                        <button type="button"
                                @click="removeAnimeFavorite"
                                v-if="isFavorite"
                                class="bg-black text-white font-bold rounded border-b-2 border-orange-400 hover:border-orange-400 hover:bg-orange-400 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                        >
                        <span class="mr-2">
                            Удалить
                        </span>
                            <TrashSvg classes="size-6 fill-none"/>
                        </button>

                        <button type="button"
                                @click="addAnimeFavorite"
                                class="bg-black text-white font-bold rounded border-b-2 border-lime-500 hover:border-lime-600 hover:bg-lime-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                        >
                    <span class="mr-2">
                        {{ !isFavorite ? 'Добавить' : 'Изменить' }}
                    </span>
                            <SendSvg classes="size-6 fill-none"/>
                        </button>

                        <button type="button"
                                @click="closeFavoriteModal"
                                class="bg-black text-white font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                        >
                    <span class="mr-2">
                        Отмена
                    </span>
                            <CloseSvg classes="size-6"/>
                        </button>
                    </div>
            </div>
        </div>
    </transition>
</template>
