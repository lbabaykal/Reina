<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';

export default {
    name: 'EditFolder',
    components: { ModalCloseButton, DangerButton, WarningButton, SuccessButton, LoadingSvg },
    data() {
        return {
            dataOnlyUserFolders: [Array, Object],
            idFolder: 0,
            dataFolder: {
                id: Number,
                title: String,
            },
            isEditFolderModalVisible: false,
            dataLoading: false,
        };
    },
    methods: {
        getOnlyUserFoldersData() {
            this.dataLoading = true;
            axios
                .get('/api/folders/doramas/only-user-folders')
                .then((response) => {
                    this.dataOnlyUserFolders = response.data.dataOnlyUserFolders;
                })
                .catch((error) => {
                    this.closeEditFolderModal();
                    push.warning(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        async getFolder(id) {
            this.dataLoading = true;
            await axios
                .get(`/api/folders/doramas/${id}/edit`, { id: id })
                .then((response) => {
                    this.dataFolder = response.data.folder;
                })
                .catch((error) => {
                    push.warning(error.response.data);
                    this.closeEditFolderModal();
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        updateFolder() {
            this.dataLoading = true;
            axios
                .patch(`/api/folders/doramas/${this.dataFolder.id}`, this.dataFolder)
                .then((response) => {
                    this.updateFolders();
                    this.closeEditFolderModal();
                    push.success(response.data);
                })
                .catch((error) => {
                    push.warning(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        deleteFolder() {
            this.dataLoading = true;
            axios
                .delete(`/api/folders/doramas/${this.dataFolder.id}`, this.dataFolder)
                .then((response) => {
                    this.updateFolders();
                    this.closeEditFolderModal();
                    if (+this.$route.query.folder === this.dataFolder.id) {
                        this.$router.replace({
                            query: { ...this.$route.query, folder: 0 },
                        });
                    }
                    push.success(response.data);
                })
                .catch((error) => {
                    push.warning(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = false;
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
            this.$emit('updateFolders');
        },
    },
    mounted() {},
};
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
        <div
            v-if="isEditFolderModalVisible"
            class="fixed top-0 left-0 z-40 flex h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto"
        >
            <div class="shadow-modals max-w-136 min-w-120 rounded-md bg-black/80 select-none">
                <div class="flex items-center justify-between border-b p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Редактирование папки</div>
                    <ModalCloseButton @click="closeEditFolderModal" />
                </div>

                <div
                    v-if="!this.dataLoading"
                    class="space-y-2 p-3"
                >
                    <div class="flex flex-col items-center justify-center text-lg">
                        <label
                            for="title"
                            class="mb-2 block text-white"
                        >
                            Название
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            maxlength="32"
                            v-model="this.dataFolder.title"
                            class="w-80% bg-blackSimple hover:bg-blackActive focus:bg-blackActive m-0 rounded border-x-0 border-t-0 py-2 text-center text-white transition duration-300 focus:border-b-red-400 focus:ring-0"
                        />
                    </div>
                </div>

                <div
                    v-else
                    class="flex h-32 items-center justify-center"
                >
                    <LoadingSvg classes="w-20 fill-violet-500" />
                </div>

                <div class="flex justify-center border-t border-gray-200 p-3">
                    <WarningButton
                        @click="deleteFolder"
                        text="Удалить"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <SuccessButton
                        @click="updateFolder"
                        text="Изменить"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <DangerButton
                        @click="closeEditFolderModal"
                        text="Отмена"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />
                </div>
            </div>
        </div>
    </transition>
</template>
