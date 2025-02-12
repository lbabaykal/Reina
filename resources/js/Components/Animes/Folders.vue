<script>
import LoadingSvg from "../Svg/LoadingSvg.vue";
import {useAuthStore} from "../../Stores/authStore.js";
import FolderSvg from "../Svg/FolderSvg.vue";
import PenSvg from "../Svg/PenSvg.vue";

export default {
    name: "Folders",
    components: {PenSvg, FolderSvg, LoadingSvg},
    props: {
        selectedFolder: Number,
    },
    data() {
        return {
            selectFolder: this.selectedFolder,
            dataFolders: [Array, Object],
            totalFavorites: Number,
            dataFoldersLoading: true,
            authStore: useAuthStore(),
        }
    },
    methods: {
        async getFoldersData() {
            this.dataFoldersLoading = true;
            await axios.get('/api/folders/animes')
                .then(response => {
                    this.dataFolders = response.data.folders;
                    this.totalFavorites = response.data.totalFavorites;
                })
                .catch(error => {
                    console.log(error.response)
                })
                .finally(() => {
                    this.dataFoldersLoading = false;
                });
        },
        updateSelectedFolder() {
            this.$emit('updateSelectedFolder', {
                selectedFolder: this.selectFolder,
            });
        }
    },
    computed: {
    },
    mounted() {
        this.getFoldersData();
    },
    watch: {
    },
}
</script>

<template>
    <div class="sticky top-20 w-72 bg-blackSimple shadow-[0_8px_6px_-4px_rgb(255,0,0)]">
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
                <span class="w-full h-full text-xl flex items-center justify-between truncate group-hover:bg-gray-100 group-hover:text-black">
                     <span class="pl-4 truncate">
                        Все
                    </span>
                    <span class="px-4">
                        {{ this.totalFavorites }}
                    </span>
                </span>
            </label>

            <label v-for="dataFolder in dataFolders"
                   class="w-full h-11 flex flex-row group cursor-pointer"
                   :class="[ selectFolder === dataFolder.id ? 'bg-blackActive' : '' ]"
            >
                <input type="radio"
                       name="folders"
                       v-model="this.selectFolder"
                       :value="dataFolder.id"
                       class="hidden"
                       @click=""
                       @change="updateSelectedFolder"
                />
                <span class="w-full h-full text-xl flex items-center justify-between truncate group-hover:bg-gray-100 group-hover:text-black">
                     <span class="pl-4 truncate">
                        {{ dataFolder.title }}
                    </span>
                    <span class="px-4">
                        {{ dataFolder.favorites_animes_user_count }}
                    </span>
                </span>
            </label>
        </div>
        <div v-else class="w-full h-80 flex items-center justify-center">
            <LoadingSvg classes="size-20 fill-red-500"/>
        </div>
    </div>
</template>
