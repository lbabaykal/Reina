<script>
import StarSvg from "../../Svg/StarSvg.vue";
import SendSvg from "../../Svg/SendSvg.vue";
import CloseSvg from "../../Svg/CloseSvg.vue";
import TrashSvg from "../../Svg/TrashSvg.vue";
import LoadingSvg from "../../Svg/LoadingSvg.vue";

export default {
    name: "Rating",
    components: {LoadingSvg, TrashSvg, CloseSvg, SendSvg, StarSvg},
    props: {
        doramaId: Number,
        dataUserForDorama: {
            rating: Number,
            favorite: {
                id: Number,
                title: String,
            },
        },
        isRating: Boolean,
    },
    data() {
        return {
            assessment: 0,
            dataLoading: false,
            isRatingModalVisible: false,
        }
    },
    methods: {
        addDoramaRating() {
            this.dataLoading = true;
            axios.post(`/api/doramas/${this.doramaId}/rating`, { assessment: this.assessment })
                .then(response => {
                    this.dataUserForDorama.rating = this.assessment;
                    this.closeRatingModal();
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        removeDoramaRating() {
            this.dataLoading = true;
            axios.delete(`/api/doramas/${this.doramaId}/rating`)
                .then(response => {
                    this.dataUserForDorama.rating = 0;
                    this.assessment = 0;
                    this.closeRatingModal();
                })
                .catch(error => {
                    // TODO Уведомление не получилось загрузить данные
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openRatingModal() {
            this.assessment = this.dataUserForDorama.rating;
            this.isRatingModalVisible = true;
        },
        closeRatingModal() {
            this.isRatingModalVisible = false;
        },
    },
}
</script>

<template>
    <transition
        enter-active-class="transition-all ease-in-out duration-300"
        enter-from-class="opacity-0 translate-y-10 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition-all ease-in-out duration-300"
        leave-from-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-10 scale-95"
    >
        <div v-if="isRatingModalVisible"
            class="overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-40 flex justify-center items-center w-full h-full"
        >
            <div class="bg-black/80 rounded select-none shadow-modals min-w-128 max-w-136">
                <div class="flex items-center justify-between p-2 border-b rounded-t">
                    <div class="text-xl text-white truncate pl-8 mx-auto">
                        Оценить
                    </div>
                    <button type="button"
                            @click="closeRatingModal"
                            class="hover:bg-red-400 hover:text-black fill-white hover:fill-black text-sm p-1 inline-flex justify-center items-center rounded">
                        <CloseSvg classes="size-6"/>
                    </button>
                </div>

                <div class="p-3 space-y-2 text-white"
                     v-if="!dataLoading"
                >
                    <div class="w-full text-center text-lg"
                         v-if="isRating"
                    >
                        Ваша оценка: {{ dataUserForDorama.rating }}
                    </div>
                    <div class="w-full text-center text-lg"
                         v-else
                    >
                        Вы не оценивали данное аниме
                    </div>

                    <div class="flex flex-row justify-center items-center text-xl">
                        <div v-for="i in 10" :key="i"
                             class="flex"
                        >
                            <input :id="i"
                                   :value="i"
                                   v-model="assessment"
                                   type="radio"
                                   name="rating"
                                   class="hidden peer"
                            />
                            <label :for="i"
                                   class="peer-checked:text-red-400 flex flex-col items-center cursor-pointer mx-1.5  hover:text-yellow-300"
                            >
                                <StarSvg class="size-10 p-1" />
                                <span> {{ i }} </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div v-else
                     class="flex items-center justify-center h-32"
                >
                    <LoadingSvg classes="w-20 fill-red-500"/>
                </div>

                <div class="flex justify-center p-3 border-t border-gray-200 rounded-b">
                    <button type="button"
                            @click="removeDoramaRating"
                            v-if="isRating"
                            class="bg-black text-white font-bold rounded border-b-2 border-orange-400 hover:border-orange-400 hover:bg-orange-400 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                        <span class="mr-2">
                            Удалить
                        </span>
                        <TrashSvg classes="size-6 fill-none"/>
                    </button>

                    <button type="button"
                            @click="addDoramaRating"
                            class="bg-black text-white font-bold rounded border-b-2 border-lime-500 hover:border-lime-600 hover:bg-lime-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                    <span class="mr-2">
                        {{ !isRating ? 'Оценить' : 'Изменить' }}
                    </span>
                        <SendSvg classes="size-6 fill-none"/>
                    </button>

                    <button type="button"
                            @click="closeRatingModal"
                            class="bg-black text-white font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500 hover:text-black shadow-md py-2 px-4 inline-flex items-center mx-2"
                    >
                    <span class="mr-2">
                        Отмена
                    </span>
                        <CloseSvg classes="size-6"/>
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>
