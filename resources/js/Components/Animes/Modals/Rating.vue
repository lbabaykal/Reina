<script>
import StarSvg from '../../Svg/StarSvg.vue';
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import { push } from 'notivue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';

export default {
    name: 'Rating',
    components: { ModalCloseButton, WarningButton, SuccessButton, DangerButton, LoadingSvg, StarSvg },
    props: {
        animeId: Number,
        dataUserForAnime: {
            rating: Number,
            favorite: {
                id: Number,
                title: String,
            },
        },
        isRatingUser: Boolean,
    },
    data() {
        return {
            assessment: 0,
            dataLoading: false,
            isRatingModalVisible: false,
        };
    },
    methods: {
        addAnimeRating() {
            this.dataLoading = true;
            if (!this.isRatingUser) {
                axios
                    .post(`/api/animes/${this.animeId}/rating`, { assessment: this.assessment })
                    .then((response) => {
                        this.dataUserForAnime.rating = this.assessment;
                        this.closeRatingModal();
                        push.success(response.data);
                    })
                    .catch((error) => {
                        push.error(error.response.data);
                    })
                    .finally(() => {
                        this.dataLoading = false;
                    });
            } else {
                axios
                    .patch(`/api/animes/${this.animeId}/rating`, { assessment: this.assessment })
                    .then((response) => {
                        this.dataUserForAnime.rating = this.assessment;
                        this.closeRatingModal();
                        push.success(response.data);
                    })
                    .catch((error) => {
                        push.error(error.response.data);
                    })
                    .finally(() => {
                        this.dataLoading = false;
                    });
            }
        },
        removeAnimeRating() {
            this.dataLoading = true;
            axios
                .delete(`/api/animes/${this.animeId}/rating`)
                .then((response) => {
                    this.dataUserForAnime.rating = 0;
                    this.assessment = 0;
                    this.closeRatingModal();
                    push.success(response.data);
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.dataLoading = false;
                });
        },
        openRatingModal() {
            this.assessment = this.dataUserForAnime.rating;
            this.isRatingModalVisible = true;
        },
        closeRatingModal() {
            this.isRatingModalVisible = false;
        },
    },
};
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
        <div
            v-if="isRatingModalVisible"
            class="fixed top-0 left-0 z-40 flex h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto"
        >
            <div class="shadow-modals max-w-136 min-w-128 rounded-md bg-black/80 select-none">
                <div class="flex items-center justify-between border-b border-gray-400 p-2">
                    <div class="mx-auto truncate pl-8 text-xl text-white">Оценить</div>
                    <ModalCloseButton @click="closeRatingModal" />
                </div>

                <div class="relative space-y-2 p-3 text-white">
                    <div
                        class="absolute top-0 left-0 flex h-full w-full items-center justify-center bg-black/60"
                        v-if="dataLoading"
                    >
                        <LoadingSvg classes="w-20 fill-red-500" />
                    </div>

                    <div
                        class="w-full text-center text-lg"
                        v-if="isRatingUser"
                    >
                        Ваша оценка: {{ dataUserForAnime.rating }}
                    </div>
                    <div
                        class="w-full text-center text-lg"
                        v-else
                    >
                        Вы не оценивали данное аниме
                    </div>

                    <div class="flex flex-row items-center justify-center text-xl">
                        <div
                            v-for="i in 10"
                            :key="i"
                            class="flex"
                        >
                            <input
                                :id="i"
                                :value="i"
                                v-model="assessment"
                                type="radio"
                                name="rating"
                                class="peer hidden"
                            />
                            <label
                                :for="i"
                                class="mx-1.5 flex cursor-pointer flex-col items-center peer-checked:text-red-400 hover:text-yellow-300"
                            >
                                <StarSvg class="size-10 p-1" />
                                <span> {{ i }} </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center border-t border-gray-400 p-3">
                    <WarningButton
                        v-if="isRatingUser"
                        text="Удалить"
                        @click="removeAnimeRating"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <SuccessButton
                        :text="!isRatingUser ? 'Оценить' : 'Изменить'"
                        @click="addAnimeRating"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />

                    <DangerButton
                        text="Отмена"
                        @click="closeRatingModal"
                        :disabledButton="dataLoading"
                        class="mx-2"
                    />
                </div>
            </div>
        </div>
    </transition>
</template>
