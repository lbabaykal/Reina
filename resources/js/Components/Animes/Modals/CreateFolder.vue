<script>
import TrashSvg from "../../Svg/TrashSvg.vue";
import CloseSvg from "../../Svg/CloseSvg.vue";
import SendSvg from "../../Svg/SendSvg.vue";
import LoadingSvg from "../../Svg/LoadingSvg.vue";
import StarSvg from "../../Svg/StarSvg.vue";

export default {
    name: "CreateFolder",
    components: {StarSvg, LoadingSvg, SendSvg, CloseSvg, TrashSvg},
    data() {
        return {
            titleFolder: '',
            isCreateFolderModalVisible: false,
        }
    },
    methods: {
        createFolder() {
            this.dataLoading = true;
            axios.post(`/api/folders/animes/`, { title: this.titleFolder })
                .then(response => {
                    // TODO Уведомление что папка успешно создана
                    this.updateFolders();
                    this.closeCreateFolderModal();
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                });
        },
        openCreateFolderModal() {
            this.titleFolder = '';
            this.isCreateFolderModalVisible = true;
        },
        closeCreateFolderModal() {
            this.isCreateFolderModalVisible = false;
        },
        updateFolders() {
            this.$emit("updateFolders");
        }
    },
}
</script>

<template>
    <transition
        enter-active-class="transition-all ease-out duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-all ease-in duration-200"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="isCreateFolderModalVisible"
             class="overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-40 flex justify-center items-center w-full h-full"
        >
            <div class="bg-black/80 rounded select-none shadow-modals min-w-120 max-w-136">
                <div class="flex items-center justify-between p-2 border-b rounded-t">
                    <div class="text-xl text-white truncate pl-8 mx-auto">
                        Добавление папки
                    </div>
                    <button type="button"
                            @click="closeCreateFolderModal"
                            class="hover:bg-red-400 hover:text-black fill-white hover:fill-black text-sm p-1 inline-flex justify-center items-center rounded">
                        <CloseSvg classes="size-6"/>
                    </button>
                </div>

                <div class="p-3 space-y-2">
                    <div class="flex flex-col justify-center items-center text-lg">
                        <label for="title"
                               class="block mb-2 text-white"
                        >
                            Название
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               v-model="titleFolder"
                               class="w-80% bg-blackSimple text-white border-x-0 border-t-0 duration-300 transition text-center rounded
                                        focus:ring-0 focus:border-b-red-400 hover:bg-blackActive focus:bg-blackActive py-2 m-0"
                        >
                    </div>
                </div>

                <div class="flex justify-center p-3 border-t border-gray-200 rounded-b">
                    <button type="button"
                            @click="createFolder"
                            class="bg-black text-white font-bold rounded border-b-2 border-lime-500 hover:border-lime-600 hover:bg-lime-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                        <span class="mr-2">
                            Добавить
                        </span>
                        <SendSvg classes="size-6 fill-none"/>
                    </button>

                    <button type="button"
                            @click="closeCreateFolderModal"
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
