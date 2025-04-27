<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';
import SwitchInput from '../../ui/Input/SwitchInput.vue';

export default {
    name: 'CreateFolder',
    components: { SwitchInput, DangerButton, SuccessButton, LoadingSvg, ModalCloseButton },
    data() {
        return {
            folder: {
                name: '',
                is_private: false,
            },
            isCreateFolderModalVisible: false,
            dataLoading: false,
        };
    },
    methods: {
        createFolder() {
            this.dataLoading = true;
            axios
                .post(`/api/folders/animes/`, this.folder)
                .then((response) => {
                    this.updateFolders();
                    this.closeCreateFolderModal();
                    push.success(response.data);
                })
                .catch((error) => {
                    push.warning(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openCreateFolderModal() {
            this.folder = {
                name: '',
                is_private: false,
            };
            this.isCreateFolderModalVisible = true;
        },
        closeCreateFolderModal() {
            this.isCreateFolderModalVisible = false;
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
            v-if="isCreateFolderModalVisible"
            class="fixed top-0 left-0 z-40 flex h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto"
        >
            <div class="shadow-modals-white max-w-96 min-w-88 rounded-md bg-black select-none">
                <div class="flex items-center justify-between border-b border-gray-400 p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Добавление папки</div>
                    <ModalCloseButton @click="closeCreateFolderModal" />
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
                                    for="name"
                                    class="mb-2 block text-white"
                                >
                                    Название
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    maxlength="32"
                                    v-model="folder.name"
                                    class="bg-blackSimple hover:bg-blackActive focus:bg-blackActive w-full rounded px-3 py-1.5 text-center text-white transition duration-300"
                                />
                            </div>
                        </div>
                        <div class="flex flex-row items-center">
                            <div class="w-full">
                                <div class="mb-1">Публичная</div>
                                <div class="text-sm text-neutral-500">Все пользователи смогут просмотреть</div>
                            </div>
                            <SwitchInput v-model="folder.is_private" />
                        </div>
                    </div>
                </div>

                <div class="flex justify-center border-t border-gray-400 p-2">
                    <SuccessButton
                        @click="createFolder"
                        text="Добавить"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <DangerButton
                        @click="closeCreateFolderModal"
                        text="Отмена"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />
                </div>
            </div>
        </div>
    </transition>
</template>
