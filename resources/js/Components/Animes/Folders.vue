<script>
import LoadingSvg from "../Svg/LoadingSvg.vue";
import {useAuthStore} from "../../Stores/authStore.js";
import FolderSvg from "../Svg/FolderSvg.vue";
import PenSvg from "../Svg/PenSvg.vue";
import Favorite from "./Modals/Favorite.vue";
import CreateFolder from "./Modals/CreateFolder.vue";
import EditFolder from "./Modals/EditFolder.vue";

export default {
    name: "Folders",
    components: {EditFolder, CreateFolder, Favorite, PenSvg, FolderSvg, LoadingSvg},
    props: {
        selectedFolder: Number,
    },
    data() {
        return {
            selectFolder: this.selectedFolder,
            dataAllUserFolders: [Array, Object],
            totalFavorites: Number,
            dataFoldersLoading: true,
            authStore: useAuthStore(),
            isEditFoldersButtons: false,
        }
    },
    methods: {
        async getAllUserFoldersData() {
            this.dataFoldersLoading = true;
            await axios.get('/api/folders/animes/all-user-folders')
                .then(response => {
                    this.dataAllUserFolders = response.data.allUserFolders;
                    this.totalFavorites = response.data.totalFavorites;
                    this.dataFoldersLoading = false;
                })
                .catch(error => {
                    console.log(error.response.message)
                });
        },
        updateSelectedFolder() {
            this.$emit('updateSelectedFolder', {
                selectedFolder: this.selectFolder,
            });
        },
        openCreateFolderModal() {
            this.$refs.createFolderRef.openCreateFolderModal();
        },
        openEditFolderModal(id) {
            this.$refs.editFolderRef.openEditFolderModal(id);
        },
        toggleEditFoldersButton() {
            this.isEditFoldersButtons = !this.isEditFoldersButtons;
        },
    },
    watch: {
        selectedFolder(value) {
            this.selectFolder = value;
        }
    },
    mounted() {
        this.getAllUserFoldersData();
    },
}
</script>

<template>
    <div class="w-72 shadow-[0_8px_6px_-4px_rgb(255,0,0)] bg-blackSimple rounded-sm overflow-hidden select-none">
        <div class="flex flex-row justify-between items-center">
            <div @click="openCreateFolderModal"
                 class="size-10 flex items-center justify-center text-black bg-orange-400 hover:text-white hover:bg-red-500 cursor-pointer"
            >
                <FolderSvg classes="size-6 fill-none"/>
            </div>
            <div class="text-xl">
                Ваши папки
            </div>
            <div @click="toggleEditFoldersButton"
                 class="size-10 flex items-center justify-center
                 text-black bg-white
                 hover:text-white hover:bg-sky-500 cursor-pointer
"
                 :class="[ isEditFoldersButtons ? 'bg-sky-500! text-white' : '' ]"
            >
                <PenSvg classes="size-5"/>
            </div>
        </div>

        <div v-if="!dataFoldersLoading">
            <label class="w-full h-10 flex flex-row group cursor-pointer"
                   :class="[ selectFolder === 0 ? 'bg-blackActive' : '' ]"
            >
                <input type="radio"
                       name="folders"
                       v-model="this.selectFolder"
                       :value="0"
                       class="hidden"
                       @click=""
                       @change="updateSelectedFolder"
                />
                <span class="w-full h-full text-lg flex items-center justify-between truncate group-hover:bg-white group-hover:text-black">
                    <span class="pl-4 truncate font">
                        Все
                    </span>
                    <span class="px-4">
                        {{ this.totalFavorites }}
                    </span>
                </span>
            </label>

            <div v-for="dataFolder in dataAllUserFolders"
                 class="flex flex-row"
            >
                <label class="w-full h-10 group cursor-pointer"
                    :class="[ selectFolder === dataFolder.id ? 'bg-blackActive' : '' ]">
                    <input type="radio"
                           name="folders"
                           v-model="this.selectFolder"
                           :value="dataFolder.id"
                           class="hidden"
                           @click=""
                           @change="updateSelectedFolder"
                    />
                    <span class="w-full h-full text-lg flex items-center justify-between truncate group-hover:bg-white group-hover:text-black">
                        <span class="pl-4 truncate">
                            {{ dataFolder.title }}
                        </span>
                        <span class="px-4">
                            {{ dataFolder.favorites_animes_user_count }}
                        </span>
                    </span>
                </label>
                <span @click="openEditFolderModal(dataFolder.id)"
                      v-if="dataFolder.user_id === authStore.user.id && isEditFoldersButtons"
                      class="w-10 h-10 min-w-10 flex items-center justify-center cursor-pointer
                             text-gray-500 hover:!text-white
                             hover:!bg-sky-500
                             group-hover:bg-white"
                >
                    <PenSvg classes="size-5"/>
                </span>
            </div>
        </div>
        <div v-else class="w-full h-80 flex items-center justify-center">
            <LoadingSvg classes="size-20 fill-red-500"/>
        </div>

        <CreateFolder ref="createFolderRef"
                      @updateFolders="getAllUserFoldersData"
        />
        <EditFolder ref="editFolderRef"
                    @updateFolders="getAllUserFoldersData"
        />
    </div>
</template>
