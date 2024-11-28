<script>
import SearchSvg from "./Svg/SearchSvg.vue";
import FilterSvg from "./Svg/FilterSvg.vue";
import DownArrowSvg from "./Svg/DownArrowSvg.vue";
import QuestionMarkSvg from "./Svg/QuestionMarkSvg.vue";

export default {
    name: "Search",
    components: {QuestionMarkSvg, DownArrowSvg, FilterSvg, SearchSvg},
    props: {},
    data() {
        return {
            searchText: null,
            dataTypes: [],
            dataGenres: [],
            dataStudios: [],
            dataCountries: [],
            selectTypes: [],
            selectGenres: [],
            selectStudios: [],
            selectCountries: [],
            strict_genre: null,
            strict_studio: null,
            year_from: null,
            year_to: null,
            selectSorting: null,
            dataLoading: false,
            isFiltersMenu: false,
        }
    },
    methods: {
        toggleFiltersMenu() {
            this.isFiltersMenu = !this.isFiltersMenu;
        },
        getSearchData() {
            axios.get('api/search-data')
                .then(response => {
                    console.log(response);
                    if (response.data.types &&
                        response.data.genres &&
                        response.data.studios &&
                        response.data.countries
                    ) {
                        this.dataTypes = response.data.types;
                        this.dataGenres = response.data.genres;
                        this.dataStudios = response.data.studios;
                        this.dataCountries = response.data.countries;
                    }
                })
                .catch(error => {
                    console.log(error.response) // TODO ошибка загрузки данных для поиска
                });
        },
        updateData() {
            this.$emit('updateAnimesData');
        },
        updateDataFilters() {
            console.log(this.searchText);
            this.$emit('updateSelectFilters', {
                searchText: this.searchText,
                types: this.selectTypes,
                genres: this.selectGenres,
                studios: this.selectStudios,
                countries: this.selectCountries,
                strict_genre: this.strict_genre,
                strict_studio: this.strict_studio,
                year_from: this.year_from,
                year_to: this.year_to,
                sorting: this.selectSorting,
            });
        },
    },
    created() {
        this.getSearchData();
    },
}
</script>

<template>
    <div>
        <div class="w-full">
            <nav class="flex flex-row justify-between px-4 py-2.5">

                <!--                <button-->
                <!--                    class="flex items-center justify-between w-[200] py-2 px-3 font-medium text-white bg-blackSimple border-b border-love hover:bg-blackActive"-->
                <!--                >-->
                <!--                    {{ Сортировка }}-->
                <!--                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"-->
                <!--                         viewBox="0 0 10 6">-->
                <!--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"-->
                <!--                              d="m1 1 4 4 4-4"/>-->
                <!--                    </svg>-->
                <!--                </button>-->


                <select name="sorting"
                        class="flex items-center justify-between w-[240] py-2 px-3 font-medium text-white bg-blackSimple border-b border-love hover:bg-blackActive"
                >
                    <option value="1">По дате добавления</option>
                    <option value="2">По рейтингу</option>
                    <option value="3">По премьере</option>
                </select>

                <div class="flex items-center justify-between">
                    <input type="search"
                           name="title"
                           placeholder="Поиск по ключевым словам..."
                           v-model="searchText"
                           class="w-[600px] bg-blackSimple text-white border-x-0 border-t-0 duration-200 transition text-center rounded-s-md focus:ring-0 focus:border-b-love hover:bg-blackActive focus:bg-blackActive"
                    />

                    <button @click="updateData"
                            class="px-5 h-full text-love hover:text-white border border-love hover:bg-love rounded-e-md"
                    >
                        <SearchSvg class="h-7 w-7"/>
                    </button>
                </div>

                <button @click="toggleFiltersMenu"
                        class="flex items-center justify-between w-[200] py-2 px-3 font-medium text-white bg-blackSimple border-b border-love hover:bg-blackActive"
                        type="button"
                >
                    <FilterSvg class="w-6 h-6"/>
                    <span class="px-6">
                        Фильтры
                    </span>
                    <DownArrowSvg class="w-3 h-3 ms-1"/>
                </button>
            </nav>

            <div v-show="isFiltersMenu"
                 class="bg-blackSimple border-blackActive shadow-sm border-y"
            >
                <div class="flex flex-row justify-center">
                    <div class="bg-blackSimple text-white w-60 overflow-hidden select-none mx-5">
                        <div class="text-center font-bold py-2.5">
                            Тип
                        </div>
                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataType in dataTypes" :key="dataType.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`types_${dataType.slug}`"
                                           type="checkbox"
                                           name="types[]"
                                           :value="`${dataType.slug}`"
                                           v-model="this.selectTypes"
                                           class="w-4 h-4 p-2 mx-1 text-love bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
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

                    <div class="bg-blackSimple text-white w-60 overflow-hidden select-none mx-5">
                        <div class="font-bold flex flex-row justify-center items-center py-2.5">
                            Жанр
                            <label class="inline-flex items-center cursor-pointer ms-3">
                                <input type="checkbox"
                                       name="strict_genre"
                                       class="sr-only peer"
                                       v-model="strict_genre"
                                       @change="updateDataFilters"
                                >
                                <span
                                    class="relative w-9 h-5 bg-red-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-400 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-lime-300"></span>
                                <button type="button" class="ml-3">
                                    <QuestionMarkSvg class="w-5 h-5"/>
                                </button>
                            </label>
                        </div>

                        <div
                            class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip border border-gray-500">
                            ВКЛ: Строгий поиск.<br>
                            ВЫКЛ: Нестрогий поиск.
                        </div>

                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataGenre in dataGenres" :key="dataGenre.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`genres_${dataGenre.slug}`"
                                           type="checkbox"
                                           name="genres[]"
                                           :value="`${dataGenre.slug}`"
                                           v-model="this.selectGenres"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-love bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
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

                    <div class="bg-blackSimple text-white w-60 overflow-hidden select-none mx-5">
                        <div class="font-bold flex flex-row justify-center items-center py-2.5">
                            Студия
                            <label class="inline-flex items-center cursor-pointer ms-3">
                                <input type="checkbox"
                                       name="strict_studio"
                                       class="sr-only peer"
                                       v-model="strict_studio"
                                       @change="updateDataFilters"
                                >
                                <span
                                    class="relative w-9 h-5 bg-red-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-400 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-lime-300"></span>

                                <button type="button" class="ml-3">
                                    <QuestionMarkSvg class="w-5 h-5"/>
                                </button>
                            </label>
                        </div>

                        <div class="absolute z-50 invisible px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip border border-gray-500">
                            ВКЛ: Строгий поиск.<br>
                            ВЫКЛ: Нестрогий поиск.
                        </div>

                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataStudio in dataStudios" :key="dataStudio.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`studios_${dataStudio.slug}`"
                                           type="checkbox"
                                           name="studios[]"
                                           :value="`${dataStudio.slug}`"
                                           v-model="this.selectGenres"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-love bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
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

                    <div class="bg-blackSimple text-white w-60 overflow-hidden select-none mx-5">
                        <div class="text-center font-bold py-2.5">
                            Страна
                        </div>
                        <ul class="min-h-20 max-h-64 px-2 overflow-y-auto">
                            <li v-for="dataCountry in dataCountries" :key="dataCountry.id">
                                <div class="flex items-center ps-2 rounded hover:bg-blackActive">
                                    <input :id="`studios_${dataCountry.slug}`"
                                           type="checkbox"
                                           name="countries[]"
                                           :value="`${dataCountry.slug}`"
                                           v-model="this.selectCountries"
                                           @change="updateDataFilters"
                                           class="w-4 h-4 p-2 mx-1 text-love bg-gray-500 border-gray-500 rounded ring-0 focus:ring-0"
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

                    <div class="bg-blackSimple text-white w-60 overflow-hidden select-none mx-3">
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
                                       v-model="year_from"
                                       type="number"
                                       min="1970"
                                       max="2030"
                                       placeholder="Введите год"
                                       class="py-1.5 w-full text-center text-white bg-blackActive rounded-e-md border-none focus:ring-love"
                                >
                            </div>
                            <div class="relative">
                                <label for="year_fromRange" class="sr-only"></label>
                                <input id="year_fromRange"
                                       type="range"
                                       v-model="year_from"
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
                                       v-model="year_to"
                                       type="number"
                                       min="1970"
                                       max="2030"
                                       placeholder="Введите год"
                                       class="py-1.5 w-full text-center text-white bg-blackActive rounded-e-md border-none focus:ring-love"
                                >
                            </div>
                            <div class="relative">
                                <label for="year_toRange" class="sr-only"></label>
                                <input id="year_toRange"
                                       type="range"
                                       v-model="year_to"
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
    </div>
</template>
