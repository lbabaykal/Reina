<script>
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';

export default {
    name: 'CreateFolder',
    components: { ModalCloseButton, DangerButton, SuccessButton, LoadingSvg },
    data() {
        return {
            titleFolder: '',
            isCreateFolderModalVisible: false,
            dataLoading: false,
        };
    },
    methods: {
        createFolder() {
            this.dataLoading = true;
            axios
                .post(`/api/folders/doramas/`, { title: this.titleFolder })
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
            this.titleFolder = '';
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
            <div class="shadow-modals max-w-136 min-w-120 rounded-md bg-black/80 select-none">
                <div class="flex items-center justify-between border-b p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Добавление папки</div>
                    <ModalCloseButton @click="closeCreateFolderModal" />
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
                            v-model="titleFolder"
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
