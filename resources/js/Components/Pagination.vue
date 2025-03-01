<script>
export default {
    name: "Pagination",
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
            this.$emit("pageChange", page);
        },
    },
}
</script>

<template>
    <div>
        <div v-if="dataPagination.last_page > 1" class="flex flex-col items-center py-8 select-none">
            <div class="flex text-white">
                <a v-if="dataPagination.current_page !== 1"
                   @click.prevent="changePage(dataPagination.current_page - 1)"
                   class="h-11 w-11 mr-1 flex justify-center items-center rounded-full bg-blackSimple cursor-pointer hover:bg-linear-to-tr from-lime-600 to-lime-400 hover:text-white"
                >
                    ❮
                </a>

                <div class="flex h-11 font-medium rounded-full bg-blackSimple">
                    <div v-for="link in dataPagination.links.slice(1, -1)" class="w-12 leading-5">
                        <template v-if="Number(link.label)">
                            <a @click.prevent="changePage(link.label)"
                               class="h-full w-full flex justify-center items-center cursor-pointer rounded-full"
                               :class="link.active ? 'bg-linear-to-tr from-pink-600 to-pink-400 text-white' : 'hover:bg-linear-to-tr from-lime-600 to-lime-400 hover:text-white'"
                            >
                                {{ link.label }}
                            </a>
                        </template>

                        <template v-if="String('...') === link.label">
                            <a @click.prevent=""
                               class="h-full w-full flex justify-center items-center cursor-pointer rounded-full bg-linear-to-tr from-blue-600 to-blue-400"
                            >
                                ...
                            </a>
                        </template>
                    </div>
                </div>

                <a v-if="dataPagination.current_page !== dataPagination.last_page"
                   @click.prevent="changePage(dataPagination.current_page + 1)"
                   class="h-11 w-11 ml-1 flex justify-center items-center rounded-full bg-blackSimple cursor-pointer hover:bg-linear-to-tr from-lime-600 to-lime-400 hover:text-white"
                >
                    ❯
                </a>
            </div>
        </div>
    </div>
</template>
