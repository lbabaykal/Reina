<script>
export default {
    name: 'Pagination',
    props: {
        dataPagination: {
            links: [],
            current_page: Number,
            from: Number,
            last_page: Number,
            per_page: Number,
            to: Number,
            total: Number,
        },
    },
    methods: {
        changePage(page) {
            this.$emit('pageChange', page);
        },
    },
};
</script>

<template>
    <div>
        <div
            v-if="dataPagination.last_page > 1"
            class="flex flex-col items-center py-8 select-none"
        >
            <div class="flex text-white">
                <a
                    v-if="dataPagination.current_page !== 1"
                    @click.prevent="changePage(dataPagination.current_page - 1)"
                    class="bg-blackSimple relative mr-1 flex size-11 cursor-pointer items-center justify-center rounded-full from-lime-600 to-lime-400 hover:bg-linear-to-tr hover:text-white"
                >
                    <span class="absolute"> ❮ </span>
                </a>

                <div class="bg-blackSimple flex h-11 rounded-full font-medium">
                    <div
                        v-for="link in dataPagination.links.slice(1, -1)"
                        class="w-11 leading-5"
                    >
                        <template v-if="Number(link.label)">
                            <a
                                @click.prevent="changePage(link.label)"
                                class="flex relative size-11 cursor-pointer items-center justify-center rounded-full"
                                :class="
                                    link.active
                                        ? 'bg-linear-to-tr from-pink-600 to-pink-400 text-white'
                                        : 'from-lime-600 to-lime-400 hover:bg-linear-to-tr hover:text-white'
                                "
                            >
                                <span class="absolute"> {{ link.label }} </span>
                            </a>
                        </template>

                        <template v-if="String('...') === link.label">
                            <a
                                @click.prevent=""
                                class="flex size-11 cursor-pointer items-center justify-center rounded-full bg-linear-to-tr from-blue-600 to-blue-400"
                            >
                                ...
                            </a>
                        </template>
                    </div>
                </div>

                <a
                    v-if="dataPagination.current_page !== dataPagination.last_page"
                    @click.prevent="changePage(dataPagination.current_page + 1)"
                    class="bg-blackSimple relative ml-1 flex size-11 cursor-pointer items-center justify-center rounded-full from-lime-600 to-lime-400 hover:bg-linear-to-tr hover:text-white"
                >
                    <span class="absolute"> ❯ </span>
                </a>
            </div>
        </div>
    </div>
</template>
