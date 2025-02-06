<script>
import SearchSvg from "./Svg/SearchSvg.vue";
import FilterSvg from "./Svg/FilterSvg.vue";
import DownArrowSvg from "./Svg/DownArrowSvg.vue";
import QuestionMarkSvg from "./Svg/QuestionMarkSvg.vue";
import SortingSvg from "./Svg/SortingSvg.vue";
import ToolTip from "./ToolTip.vue";

export default {
    name: "Search",
    components: {ToolTip, SortingSvg, QuestionMarkSvg, DownArrowSvg, FilterSvg, SearchSvg},
    props: {
        selectedDataSearch: {
            title: String,
            types: Array,
            genres: Array,
            studios: Array,
            countries: Array,
            strict_genre: Boolean,
            strict_studio: Boolean,
            year_from: Number,
            year_to: Number,
            sorting: String,
        },
    },
    data() {
        return {
            dataSearch: {
                types: [],
                genres: [],
                studios: [],
                countries: [],
                sorting: [],
            },
            dataLoading: false,
            isFiltersMenu: false,
            isSorting: false,
        }
    },
    methods: {
        toggleFiltersMenu() {
            this.isFiltersMenu = !this.isFiltersMenu;
        },
        toggleSorting() {
            this.isSorting = !this.isSorting;
        },
        getSearchData() {
            axios.get('/api/search-data')
                .then(response => {
                    if (response.data.types &&
                        response.data.genres &&
                        response.data.studios &&
                        response.data.countries &&
                        response.data.sorting
                    ) {
                        this.dataSearch = {
                            types: response.data.types,
                            genres: response.data.genres,
                            studios: response.data.studios,
                            countries: response.data.countries,
                            sorting: response.data.sorting,
                        }
                    }
                })
                .catch(error => {
                    console.log(error.response) // TODO ошибка загрузки данных для поиска
                });
        },
        updateDataFilters() {
            this.$emit('updateSelectFilters', {
                selectedDataSearch: this.selectedDataSearch
            });
        },
    },
    mounted() {
        this.getSearchData();
    },
}
</script>

<template>
        <div class="w-full">
            <nav class="flex flex-row justify-between px-4 py-2.5">

                <div class="relative">
                    <button @click="toggleSorting"
                            class="flex items-center justify-between w-56 py-2 px-3 font-medium text-white bg-blackSimple border-b border-red-400 hover:bg-blackActive"
                            type="button"
                    >
                        <DownArrowSvg classes="w-4 h-4"/>
                        <span class="px-6">
                            Сортировка
                        </span>
                        <SortingSvg classes="w-6 h-6"/>
                    </button>

                    <div v-show="isSorting"
                         class="absolute z-20 bg-blackSimple text-white w-60 mt-2 select-none rounded shadow-modals"
                    >
                        <div class="flex items-center ps-2 hover:bg-blackActive"
                             v-for="dataSorting in dataSearch.sorting" :key="dataSorting.id"
                        >
                            <input :id="dataSorting.slug"
                                   type="radio"
                                   name="sorting"
                                   :value="dataSorting.slug"
                                   v-model="this.selectedDataSearch.sorting"
                                   @click="toggleSorting"
                                   @change="updateDataFilters"
                                   class="w-4 h-4 p-2 mx-1 text-red-400 bg-gray-500 border-gray-500 ring-0 focus:ring-0"
                            >
                            <label :for="dataSorting.slug"
                                   class="w-full py-2.5 ms-2 rounded truncate"
                            >
                                {{ dataSorting.title }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <input type="search"
                           name="title"
                           placeholder="Поиск по ключевым словам..."
                           v-model="selectedDataSearch.title"
                           @keydown.enter="updateDataFilters"
                           class="w-144 bg-blackSimple text-white border-x-0 border-t-0 duration-200 transition text-center rounded-s-md focus:ring-0 focus:border-b-red-400 hover:bg-blackActive focus:bg-blackActive"
                    />

                    <button @click="updateDataFilters"
                            class="px-5 h-full text-red-400 hover:text-white border border-red-400 hover:bg-red-400 rounded-e-md"
                    >
                        <SearchSvg classes="h-7 w-7"/>
                    </button>
                </div>

                <button @click="toggleFiltersMenu"
                        class="flex items-center justify-between w-56 py-2 px-3 font-medium text-white bg-blackSimple border-b border-red-400 hover:bg-blackActive"
                        type="button"
                >
                    <FilterSvg classes="w-6 h-6"/>
                    <span class="px-6">
                        Фильтры
                    </span>
                    <DownArrowSvg classes="w-4 h-4"/>
                </button>
            </nav>

            <div v-show="isFiltersMenu"
                 class="bg-blackSimple border-blackActive border-y"
            >
                <div class="flex flex-row justify-center">
                    <div class="bg-blackSimple text-white w-60 select-none mx-5">
                        <div class="text-center font-bold py-2.5">
                            Тип
                        </div>
                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataType in dataSearch.types" :key="dataType.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`types_${dataType.slug}`"
                                           type="checkbox"
                                           name="types[]"
                                           :value="dataType.slug"
                                           v-model="this.selectedDataSearch.types"
                                           class="w-4 h-4 p-2 mx-1 text-red-400 bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
                                           @change="updateDataFilters"
                                    >
                                    <label :for="`types_${dataType.slug}`"
                                           class="w-full py-2.5 ms-2 rounded truncate"
                                    >
                                        {{ dataType.title_ru }}
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blackSimple text-white w-60 select-none mx-5">
                        <div class="font-bold flex flex-row justify-center items-center py-2.5">
                            Жанр
                            <label class="inline-flex items-center cursor-pointer ms-3">
                                <input type="checkbox"
                                       name="strict_genre"
                                       class="sr-only peer"
                                       v-model="selectedDataSearch.strict_genre"
                                       @change="updateDataFilters"
                                >
                                <span class="relative w-9 h-5 bg-red-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-400 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-lime-300"></span>
                            </label>

                            <ToolTip classes="py-1.5 px-2 bg-gray-600 text-white font-normal text-sm"
                                     message="Строгий / Нестрогий поиск"
                            >
                                <QuestionMarkSvg classes="w-5 h-5 ml-3 cursor-pointer"/>
                            </ToolTip>
                        </div>

                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataGenre in dataSearch.genres" :key="dataGenre.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`genres_${dataGenre.slug}`"
                                           type="checkbox"
                                           name="genres[]"
                                           :value="dataGenre.slug"
                                           v-model="this.selectedDataSearch.genres"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-red-400 bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
                                    >
                                    <label :for="`genres_${dataGenre.slug}`"
                                           class="w-full py-2.5 ms-2 rounded truncate"
                                    >
                                        {{ dataGenre.title_ru }}
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blackSimple text-white w-60 select-none mx-5">
                        <div class="font-bold flex flex-row justify-center items-center py-2.5">
                            Студия
                            <label class="inline-flex items-center cursor-pointer ms-3">
                                <input type="checkbox"
                                       name="strict_studio"
                                       class="sr-only peer"
                                       v-model="selectedDataSearch.strict_studio"
                                       @change="updateDataFilters"
                                >
                                <span class="relative w-9 h-5 bg-red-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-400 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-lime-300"></span>
                            </label>
                            <ToolTip classes="py-1.5 px-2 bg-gray-600 text-white font-normal text-sm"
                                     message="Строгий / Нестрогий поиск"
                            >
                                <QuestionMarkSvg classes="w-5 h-5 ml-3 cursor-pointer"/>
                            </ToolTip>
                        </div>

                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataStudio in dataSearch.studios" :key="dataStudio.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`studios_${dataStudio.slug}`"
                                           type="checkbox"
                                           name="studios[]"
                                           :value="dataStudio.slug"
                                           v-model="this.selectedDataSearch.studios"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-red-400 bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
                                    >
                                    <label :for="`studios_${dataStudio.slug}`"
                                           class="w-full py-2.5 ms-2 rounded truncate"
                                    >
                                        {{ dataStudio.title }}
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blackSimple text-white w-60 select-none mx-5">
                        <div class="text-center font-bold py-2.5">
                            Страна
                        </div>
                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataCountry in dataSearch.countries" :key="dataCountry.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`studios_${dataCountry.slug}`"
                                           type="checkbox"
                                           name="countries[]"
                                           :value="dataCountry.slug"
                                           v-model="this.selectedDataSearch.countries"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-red-400 bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
                                    >
                                    <label :for="`studios_${dataCountry.slug}`"
                                           class="w-full py-2.5 ms-2 rounded truncate"
                                    >
                                        {{ dataCountry.title_ru }}
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="bg-blackSimple text-white w-60 select-none mx-3">
                        <div class="text-center font-bold py-2.5">
                            Год
                        </div>

                        <div class="px-2 py-2">
                            <div class="flex mb-4">
                                <div class="py-2.5 px-5 text-white rounded-s-md bg-gray-500">
                                    ОТ
                                </div>
                                <input id="year_fromInput"
                                       name="year_from"
                                       v-model="selectedDataSearch.year_from"
                                       type="number"
                                       min="1970"
                                       max="2030"
                                       placeholder="Введите год"
                                       @change="updateDataFilters"
                                       class="py-1.5 w-full text-center text-white bg-blackActive rounded-e-md border-none focus:ring-red-400"
                                >
                            </div>
                            <div class="relative">
                                <label for="year_fromRange" class="sr-only"></label>
                                <input id="year_fromRange"
                                       type="range"
                                       v-model="selectedDataSearch.year_from"
                                       min="1970"
                                       max="2030"
                                       @change="updateDataFilters"
                                       class="w-full h-2.5 bg-white rounded-lg appearance-none cursor-ew-resize range-sm in-range:bg-gray-500"
                                >
                                <span class="text-sm text-gray-300 absolute start-0 -bottom-6">1970</span>
                                <span class="text-sm text-gray-300 absolute end-0 -bottom-6">2030</span>
                            </div>
                        </div>

                        <div class="px-2 py-2 mt-10">
                            <div class="flex mb-4">
                                <div class="py-2.5 px-5 text-white rounded-s-md bg-gray-500">
                                    ДО
                                </div>
                                <input id="year_toInput"
                                       name="year_to"
                                       v-model="selectedDataSearch.year_to"
                                       type="number"
                                       min="1970"
                                       max="2030"
                                       placeholder="Введите год"
                                       @change="updateDataFilters"
                                       class="py-1.5 w-full text-center text-white bg-blackActive rounded-e-md border-none focus:ring-red-400"
                                >
                            </div>
                            <div class="relative">
                                <label for="year_toRange" class="sr-only"></label>
                                <input id="year_toRange"
                                       type="range"
                                       v-model="selectedDataSearch.year_to"
                                       min="1970"
                                       max="2030"
                                       @change="updateDataFilters"
                                       class="w-full h-2.5 bg-gray-500 rounded-lg appearance-none cursor-ew-resize range-sm"
                                >
                                <span class="text-sm text-gray-300 absolute start-0 -bottom-6">1970</span>
                                <span class="text-sm text-gray-300 absolute end-0 -bottom-6">2030</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>
