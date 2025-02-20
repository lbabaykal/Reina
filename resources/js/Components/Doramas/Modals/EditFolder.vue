<script>
import CloseSvg from "../../Svg/CloseSvg.vue";
import SendSvg from "../../Svg/SendSvg.vue";
import TrashSvg from "../../Svg/TrashSvg.vue";
import LoadingSvg from "../../Svg/LoadingSvg.vue";

export default {
    name: "EditFolder",
    components: {LoadingSvg, TrashSvg, SendSvg, CloseSvg},
    data() {
        return {
            dataOnlyUserFolders: [Array, Object],
            idFolder: 0,
            dataFolder: {
                id: Number,
                title: String,
            },
            isEditFolderModalVisible: false,
            dataLoading: true,
        }
    },
    methods: {
        getOnlyUserFoldersData() {
            this.dataLoading = false;
            axios.get('/api/folders/doramas/only-user-folders')
                .then(response => {
                    this.dataOnlyUserFolders = response.data.dataOnlyUserFolders;
                    this.dataLoading = true;
                })
                .catch(error => {
                    console.log(error.response)
                });
        },
        async getFolder(id) {
            this.dataLoading = true;
            await axios.get(`/api/folders/doramas/${id}/edit`, { id: id })
                .then(response => {
                    // TODO Уведомление что папка успешно загружена
                    this.dataFolder = response.data.folder;
                    this.dataLoading = false;
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                    this.dataLoading = false;
                });
        },
        updateFolder() {
            this.dataLoading = true;
            axios.patch(`/api/folders/doramas/${this.dataFolder.id}`, this.dataFolder )
                .then(response => {
                    // TODO Уведомление что папка успешно обновлена
                    this.updateFolders();
                    this.closeEditFolderModal();
                    this.dataLoading = false;
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                });
        },
        deleteFolder() {
            this.dataLoading = true;
            axios.delete(`/api/folders/doramas/${this.dataFolder.id}`, this.dataFolder )
                .then(response => {
                    // TODO Уведомление что папка успешно удалена
                    this.updateFolders();
                    this.closeEditFolderModal();
                    this.dataLoading = false;
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                });
        },
        openEditFolderModal(id) {
            this.getFolder(id);
            this.isEditFolderModalVisible = true;
        },
        closeEditFolderModal() {
            this.isEditFolderModalVisible = false;
        },
        updateFolders() {
            this.$emit("updateFolders");
        },
    },
    mounted() {
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
        <div v-if="isEditFolderModalVisible"
             class="overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-40 flex justify-center items-center w-full h-full"
        >
            <div class="bg-black/80 rounded select-none shadow-modals min-w-120 max-w-136">
                <div class="flex items-center justify-between p-2 border-b rounded-t">
                    <div class="text-xl text-white truncate pl-8 mx-auto">
                        Редактирование папки
                    </div>
                    <button type="button"
                            @click="closeEditFolderModal"
                            class="hover:bg-red-400 hover:text-black fill-white hover:fill-black text-sm p-1 inline-flex justify-center items-center rounded">
                        <CloseSvg classes="size-6"/>
                    </button>
                </div>

                <div v-if="!this.dataLoading"
                     class="p-3 space-y-2"
                >
                    <div class="flex flex-col justify-center items-center text-lg">
                        <label for="title"
                               class="block mb-2 text-white"
                        >
                            Название
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               v-model="this.dataFolder.title"
                               class="w-80% bg-blackSimple text-white border-x-0 border-t-0 duration-300 transition text-center rounded
                                        focus:ring-0 focus:border-b-red-400 hover:bg-blackActive focus:bg-blackActive py-2 m-0"
                        >
                    </div>
                </div>

                <div v-else
                     class="flex items-center justify-center h-32"
                >
                    <LoadingSvg classes="w-20 fill-red-500"/>
                </div>

                <div class="flex justify-center p-3 border-t border-gray-200 rounded-b">
                    <button type="button"
                            @click="deleteFolder"
                            class="bg-black text-white font-bold rounded border-b-2 border-orange-400 hover:border-orange-400 hover:bg-orange-400 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                        <span class="mr-2">
                            Удалить
                        </span>
                        <TrashSvg classes="size-6 fill-none"/>
                    </button>

                    <button type="button"
                            @click="updateFolder"
                            class="bg-black text-white font-bold rounded border-b-2 border-lime-500 hover:border-lime-600 hover:bg-lime-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                    <span class="mr-2">
                        Изменить
                    </span>
                        <SendSvg classes="size-6 fill-none"/>
                    </button>

                    <button type="button"
                            @click="closeEditFolderModal"
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
