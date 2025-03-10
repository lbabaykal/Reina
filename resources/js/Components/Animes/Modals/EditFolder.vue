<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';
import SwitchInput from '../../ui/Input/SwitchInput.vue';

export default {
    name: 'EditFolder',
    components: { SwitchInput, ModalCloseButton, DangerButton, WarningButton, SuccessButton, LoadingSvg },
    data() {
        return {
            dataOnlyUserFolders: [Array, Object],
            dataFolder: {
                id: 0,
                title: '',
                is_private: false,
            },
            isEditFolderModalVisible: false,
            dataLoading: false,
        };
    },
    methods: {
        getOnlyUserFoldersData() {
            this.dataLoading = true;
            axios
                .get('/api/folders/animes/only-user-folders')
                .then((response) => {
                    this.dataOnlyUserFolders = response.data.dataOnlyUserFolders;
                })
                .catch((error) => {
                    this.closeEditFolderModal();
                    push.warning(error.response.data.message);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        async getFolder(id) {
            this.dataLoading = true;
            await axios
                .get(`/api/folders/animes/${id}/edit`, { id: id })
                .then((response) => {
                    this.dataFolder = response.data.folder;
                })
                .catch((error) => {
                    push.warning(error.response.data.message);
                    this.closeEditFolderModal();
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        updateFolder() {
            this.dataLoading = true;
            axios
                .patch(`/api/folders/animes/${this.dataFolder.id}`, this.dataFolder)
                .then((response) => {
                    this.updateFolders();
                    this.closeEditFolderModal();
                    push.success(response.data.message);
                })
                .catch((error) => {
                    push.warning(error.response.data.message);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        deleteFolder() {
            this.dataLoading = true;
            axios
                .delete(`/api/folders/animes/${this.dataFolder.id}`, this.dataFolder)
                .then((response) => {
                    this.updateFolders();
                    this.closeEditFolderModal();
                    if (+this.$route.query.folder === this.dataFolder.id) {
                        this.$router.replace({
                            query: { ...this.$route.query, folder: 0 },
                        });
                    }
                    push.success(response.data.message);
                })
                .catch((error) => {
                    push.warning(error.response.data.message);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openEditFolderModal(id) {
            this.getFolder(id);
            this.dataFolder = {
                id: 0,
                title: '',
                is_private: false,
            };
            this.isEditFolderModalVisible = true;
        },
        closeEditFolderModal() {
            this.isEditFolderModalVisible = false;
        },
        updateFolders() {
            this.$emit('updateFolders');
        },
    },
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
            <div class="shadow-modals-white max-w-96 min-w-88 rounded-md bg-black select-none">
                <div class="flex items-center justify-between border-b border-gray-400 p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Редактирование папки</div>
                    <ModalCloseButton @click="closeEditFolderModal" />
                </div>

                <div class="relative space-y-2 p-4">
                    <div
                        v-if="this.dataLoading"
                        class="absolute top-0 left-0 z-10 flex h-full w-full items-center justify-center bg-black/60"
                    >
                        <LoadingSvg classes="w-20 fill-red-500" />
                    </div>

                    <div class="flex w-full flex-col space-y-4">
                        <div class="flex flex-row">
                            <div class="w-full">
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
                                    v-model="dataFolder.title"
                                    class="bg-blackSimple hover:bg-blackActive focus:bg-blackActive w-full rounded px-3 py-1.5 text-center text-white transition duration-300"
                                />
                            </div>
                        </div>
                        <div class="flex flex-row items-center">
                            <div class="w-full">
                                <div class="mb-1">Публичная</div>
                                <div class="text-sm text-neutral-500">Все пользователи смогут просмотреть</div>
                            </div>
                            <SwitchInput v-model="dataFolder.is_private" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-center border-t border-gray-400 p-2">
                    <WarningButton
                        @click="deleteFolder"
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
