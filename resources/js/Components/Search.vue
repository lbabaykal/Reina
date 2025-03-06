<script>
import SearchSvg from './Svg/SearchSvg.vue';
import QuestionMarkSvg from './Svg/QuestionMarkSvg.vue';
import ToolTip from './ToolTip.vue';
import SortingButton from './ui/Buttons/SortingButton.vue';
import FilterButton from './ui/Buttons/FilterButton.vue';
import PlusSvg from './Svg/PlusSvg.vue';
import MinusSvg from './Svg/MinusSvg.vue';
import CircleSvg from './Svg/CircleSvg.vue';
import { push } from 'notivue';

export default {
    name: 'Search',
    components: { CircleSvg, MinusSvg, PlusSvg, FilterButton, SortingButton, ToolTip, QuestionMarkSvg, SearchSvg },
    data() {
        return {
            dataSearch: {
                types: [],
                genres: [],
                studios: [],
                countries: [],
                sorting: [],
            },
            selectedSearchData: {
                page: 1,
                title: null,
                types: [],
                genres: [],
                genres_exclude: [],
                studios: [],
                countries: [],
                strict_genre: false,
                strict_studio: false,
                year_from: null,
                year_to: null,
                sorting: 'date_updated',
            },
            dataLoading: false,
            isFiltersMenu: false,
            isSortingMenu: false,
            pageOld: 0,
        };
    },
    methods: {
        toggleFiltersMenu() {
            this.isFiltersMenu = !this.isFiltersMenu;
        },
        toggleSorting() {
            this.isSortingMenu = !this.isSortingMenu;
        },
        async getSearchData() {
            await axios
                .get('/api/search-data')
                .then((response) => {
                    if (response.data.types && response.data.genres && response.data.studios && response.data.countries && response.data.sorting) {
                        this.dataSearch = {
                            types: response.data.types,
                            genres: response.data.genres,
                            studios: response.data.studios,
                            countries: response.data.countries,
                            sorting: response.data.sorting,
                        };
                    }
                })
                .catch((error) => {
                    push.error('Не удалось загрузить данные для фильтра.');
                });
        },
        updateDataFilters() {
            this.pageOld = this.selectedSearchData.page;

            this.$emit('updateSelectFilters', {
                selectedSearchData: this.selectedSearchData,
            });
        },
        loadQueryFromUrl() {
            const query = this.$route.query;

            this.selectedSearchData = {
                page: Number(query.page) || 1,
                types: Array.isArray(query.types) ? query.types : query.types != null ? [query.types] : [],
                genres: Array.isArray(query.genres) ? query.genres : query.genres != null ? [query.genres] : [],
                genres_exclude: Array.isArray(query.genres_exclude) ? query.genres_exclude : query.genres_exclude != null ? [query.genres_exclude] : [],
                // genres: query.genres ? query.genres.split(',') : [],
                // genres_exclude: query.genres_exclude ? query.genres_exclude.split(',') : [],
                studios: Array.isArray(query.studios) ? query.studios : query.studios != null ? [query.studios] : [],
                countries: Array.isArray(query.countries) ? query.countries : query.countries != null ? [query.countries] : [],
                title: query.title || '',
                strict_genre: query.strict_genre === 'true',
                strict_studio: query.strict_studio === 'true',
                year_from: query.year_from ? Number(query.year_from) : null,
                year_to: query.year_to ? Number(query.year_to) : null,
                sorting: query.sorting || 'date_updated',
            };
        },
        changePage(page) {
            this.selectedSearchData.page = page;
            this.routerPush();
        },
        routerPush() {
            if (this.pageOld === this.selectedSearchData.page) {
                this.selectedSearchData.page = 1;
            }

            // const query = { ...this.selectedSearchData };
            // if (Array.isArray(query.genres)) {
            //     query.genres = query.genres.join(',');
            // }
            // if (Array.isArray(query.genres_exclude)) {
            //     query.genres_exclude = query.genres_exclude.join(',');
            // }

            this.$router.push({ query: this.selectedSearchData });
        },
        changeGenres() {
            this.selectedSearchData.genres_exclude = this.selectedSearchData.genres_exclude.filter((genre) => !this.selectedSearchData.genres.includes(genre));
            this.routerPush();
        },
        changeGenresExclude() {
            this.selectedSearchData.genres = this.selectedSearchData.genres.filter((genre) => !this.selectedSearchData.genres_exclude.includes(genre));
            this.routerPush();
        },
    },
    mounted() {
        this.getSearchData();
        this.loadQueryFromUrl();
        this.updateDataFilters();
    },
    watch: {
        '$route.query': function () {
            this.loadQueryFromUrl();
            this.updateDataFilters();
        },
    },
};
</script>

<template>
    <div class="w-full">
        <nav class="flex flex-row justify-between px-4 py-2.5">
            <div class="relative">
                <SortingButton
                    @click="toggleSorting"
                    :isSortingMenu="isSortingMenu"
                    text="Сортировка"
                />

                <div
                    v-show="isSortingMenu"
                    class="bg-blackSimple shadow-modals absolute z-20 mt-2 w-60 overflow-hidden rounded-sm text-white select-none"
                >
                    <div
                        v-for="dataSorting in dataSearch.sorting"
                        :key="dataSorting.id"
                    >
                        <label class="hover:bg-blackActive flex items-center rounded-sm ps-2">
                            <input
                                type="radio"
                                name="sorting"
                                class="peer hidden"
                                :value="dataSorting.slug"
                                v-model="this.selectedSearchData.sorting"
                                @click="toggleSorting"
                                @change="routerPush"
                            />
                            <span class="mx-1 inline-block size-5 shrink-0 rounded-full bg-gray-500 peer-checked:hidden peer-indeterminate:hidden"></span>
                            <CircleSvg
                                classes="size-4 stroke-black fill-none"
                                class="mx-1 hidden size-5 shrink-0 rounded-full peer-checked:inline-block peer-checked:bg-gray-500 peer-checked:fill-red-400 peer-checked:stroke-none"
                            />
                            <span class="ms-2 truncate py-2.5">{{ dataSorting.title }}</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <input
                    type="search"
                    name="title"
                    placeholder="Поиск по ключевым словам..."
                    v-model="selectedSearchData.title"
                    @keydown.enter="routerPush"
                    class="bg-blackSimple hover:bg-blackActive focus:bg-blackActive h-10 w-144 rounded-s-md border-b border-b-gray-600 px-3 text-center text-lg text-white transition duration-300 focus:border-b-red-400"
                />

                <button
                    @click="routerPush"
                    class="h-10 cursor-pointer rounded-e-md border border-red-400 px-5 text-red-400 hover:bg-red-400 hover:text-white"
                >
                    <SearchSvg classes="h-7 w-7" />
                </button>
            </div>

            <FilterButton
                @click="toggleFiltersMenu"
                :isFiltersMenu="isFiltersMenu"
                text="Фильтры"
            />
        </nav>

        <div
            v-show="isFiltersMenu"
            class="bg-blackSimple border-blackActive border-y"
        >
            <div class="flex flex-row justify-center">
                <div class="bg-blackSimple mx-5 w-60 text-white select-none">
                    <div class="py-2.5 text-center font-bold">Тип</div>
                    <ul class="max-h-64 min-h-20 overflow-y-auto px-2">
                        <li
                            v-for="dataType in dataSearch.types"
                            :key="dataType.id"
                        >
                            <label class="hover:bg-blackActive flex items-center rounded-sm ps-2">
                                <input
                                    type="checkbox"
                                    name="types[]"
                                    class="peer hidden"
                                    :value="dataType.slug"
                                    v-model="this.selectedSearchData.types"
                                    @change="routerPush"
                                />
                                <span class="mx-1 inline-block size-5 shrink-0 rounded-sm bg-gray-500 peer-checked:hidden peer-indeterminate:hidden"></span>
                                <PlusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-checked:inline-block peer-checked:bg-lime-500"
                                />
                                <MinusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-indeterminate:inline-block peer-indeterminate:bg-red-500"
                                />
                                <span class="ms-2 truncate py-2.5">{{ dataType.title_ru }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="bg-blackSimple mx-5 w-64 text-white select-none">
                    <div class="flex flex-row items-center justify-center py-2.5 font-bold">
                        Жанр
                        <label class="ms-3 inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="strict_genre"
                                class="peer sr-only"
                                v-model="selectedSearchData.strict_genre"
                                @change="routerPush"
                            />
                            <span
                                class="peer relative h-5 w-9 rounded-full bg-red-300 peer-checked:bg-lime-300 after:absolute after:start-[2px] after:top-0.5 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-400 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full"
                            ></span>
                        </label>

                        <ToolTip
                            classes="py-1.5 px-2 bg-gray-600 text-white font-normal text-sm"
                            message="Строгий / Нестрогий поиск"
                        >
                            <QuestionMarkSvg classes="w-5 h-5 ml-3 cursor-pointer" />
                        </ToolTip>
                    </div>

                    <ul class="max-h-64 min-h-20 overflow-y-auto px-2">
                        <li
                            v-for="dataGenre in dataSearch.genres"
                            :key="dataGenre.id"
                            class="hover:bg-blackActive flex h-9 items-center justify-between rounded-sm px-1"
                        >
                            <label class="group flex size-9 items-center justify-center">
                                <input
                                    type="checkbox"
                                    name="genres[]"
                                    class="peer hidden"
                                    :value="dataGenre.slug"
                                    v-model="this.selectedSearchData.genres"
                                    @change="changeGenres"
                                />
                                <PlusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="size-5 shrink-0 rounded-sm bg-gray-500 group-hover:bg-lime-400 peer-checked:bg-lime-500"
                                />
                            </label>

                            <span class="group-hover:bg-blackActive mx-2 truncate">{{ dataGenre.title_ru }}</span>

                            <label class="group flex size-9 items-center justify-center">
                                <input
                                    type="checkbox"
                                    name="genres_exclude[]"
                                    class="peer hidden"
                                    :value="dataGenre.slug"
                                    v-model="this.selectedSearchData.genres_exclude"
                                    @change="changeGenresExclude"
                                />
                                <MinusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="size-5 shrink-0 rounded-sm bg-gray-500 group-hover:bg-rose-400 peer-checked:bg-rose-500"
                                />
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="bg-blackSimple mx-5 w-60 text-white select-none">
                    <div class="flex flex-row items-center justify-center py-2.5 font-bold">
                        Студия
                        <label class="ms-3 inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                name="strict_studio"
                                class="peer sr-only"
                                v-model="selectedSearchData.strict_studio"
                                @change="routerPush"
                            />
                            <span
                                class="peer relative h-5 w-9 rounded-full bg-red-300 peer-checked:bg-lime-300 after:absolute after:start-[2px] after:top-0.5 after:h-4 after:w-4 after:rounded-full after:border after:border-gray-400 after:bg-white after:transition-all after:content-[''] peer-checked:after:translate-x-full"
                            ></span>
                        </label>
                        <ToolTip
                            classes="py-1.5 px-2 bg-gray-600 text-white font-normal text-sm"
                            message="Строгий / Нестрогий поиск"
                        >
                            <QuestionMarkSvg classes="w-5 h-5 ml-3 cursor-pointer" />
                        </ToolTip>
                    </div>

                    <ul class="max-h-64 min-h-20 overflow-y-auto px-2">
                        <li
                            v-for="dataStudio in dataSearch.studios"
                            :key="dataStudio.id"
                        >
                            <label class="hover:bg-blackActive flex items-center rounded-sm ps-2">
                                <input
                                    type="checkbox"
                                    name="studios[]"
                                    class="peer hidden"
                                    :value="dataStudio.slug"
                                    v-model="this.selectedSearchData.studios"
                                    @change="routerPush"
                                />
                                <span class="mx-1 inline-block size-5 shrink-0 rounded-sm bg-gray-500 peer-checked:hidden peer-indeterminate:hidden"></span>
                                <PlusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-checked:inline-block peer-checked:bg-lime-500"
                                />
                                <MinusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-indeterminate:inline-block peer-indeterminate:bg-red-500"
                                />
                                <span class="ms-2 truncate py-2.5">{{ dataStudio.title }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="bg-blackSimple mx-5 w-60 text-white select-none">
                    <div class="py-2.5 text-center font-bold">Страна</div>
                    <ul class="max-h-64 min-h-20 overflow-y-auto px-2">
                        <li
                            v-for="dataCountry in dataSearch.countries"
                            :key="dataCountry.id"
                        >
                            <label class="hover:bg-blackActive flex items-center rounded-sm ps-2">
                                <input
                                    type="checkbox"
                                    name="countries[]"
                                    class="peer hidden"
                                    :value="dataCountry.slug"
                                    v-model="this.selectedSearchData.countries"
                                    @change="routerPush"
                                />
                                <span class="mx-1 inline-block size-5 shrink-0 rounded-sm bg-gray-500 peer-checked:hidden peer-indeterminate:hidden"></span>
                                <PlusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-checked:inline-block peer-checked:bg-lime-500"
                                />
                                <MinusSvg
                                    classes="size-5 stroke-black fill-none"
                                    class="mx-1 hidden size-5 shrink-0 rounded-sm peer-indeterminate:inline-block peer-indeterminate:bg-red-500"
                                />
                                <span class="ms-2 truncate py-2.5">{{ dataCountry.title_ru }}</span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="bg-blackSimple mx-3 w-60 text-white select-none">
                    <div class="py-2.5 text-center font-bold">Год</div>

                    <div class="px-2 py-2">
                        <div class="mb-4 flex">
                            <div class="rounded-s-sm bg-gray-500 px-5 py-2.5 text-white">ОТ</div>
                            <input
                                id="year_fromInput"
                                name="year_from"
                                v-model="selectedSearchData.year_from"
                                type="number"
                                min="1970"
                                max="2030"
                                placeholder="Введите год"
                                @change="routerPush"
                                class="bg-blackActive w-full rounded-e-sm border-none py-1.5 text-center text-white focus:ring-0"
                            />
                        </div>
                        <div class="relative">
                            <label
                                for="year_fromRange"
                                class="sr-only"
                            ></label>
                            <input
                                id="year_fromRange"
                                type="range"
                                v-model="selectedSearchData.year_from"
                                min="1970"
                                max="2030"
                                @change="routerPush"
                                class="range-sm h-2.5 w-full cursor-ew-resize appearance-none rounded-lg bg-white in-range:bg-gray-400"
                            />
                            <span class="absolute start-0 -bottom-6 text-sm text-gray-300">1970</span>
                            <span class="absolute end-0 -bottom-6 text-sm text-gray-300">2030</span>
                        </div>
                    </div>

                    <div class="mt-10 px-2 py-2">
                        <div class="mb-4 flex">
                            <div class="rounded-s-sm bg-gray-500 px-5 py-2.5 text-white">ДО</div>
                            <input
                                id="year_toInput"
                                name="year_to"
                                v-model="selectedSearchData.year_to"
                                type="number"
                                min="1970"
                                max="2030"
                                placeholder="Введите год"
                                @change="routerPush"
                                class="bg-blackActive w-full rounded-e-sm border-none py-1.5 text-center text-white focus:ring-0"
                            />
                        </div>
                        <div class="relative">
                            <label
                                for="year_toRange"
                                class="sr-only"
                            ></label>
                            <input
                                id="year_toRange"
                                type="range"
                                v-model="selectedSearchData.year_to"
                                min="1970"
                                max="2030"
                                @change="routerPush"
                                class="range-sm h-2.5 w-full cursor-ew-resize appearance-none rounded-lg bg-gray-400"
                            />
                            <span class="absolute start-0 -bottom-6 text-sm text-gray-300">1970</span>
                            <span class="absolute end-0 -bottom-6 text-sm text-gray-300">2030</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
