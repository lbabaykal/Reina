<script>
import { push } from 'notivue';
import WarningButton from '../../ui/Buttons/WarningButton.vue';
import SuccessButton from '../../ui/Buttons/SuccessButton.vue';
import LoadingSvg from '../../Svg/LoadingSvg.vue';
import ModalCloseButton from '../../ui/Buttons/ModalCloseButton.vue';
import DangerButton from '../../ui/Buttons/DangerButton.vue';
import ToolTip from '../../ToolTip.vue';
import StarSvg from '../../Svg/StarSvg.vue';
import { useAuthStore } from '../../../Stores/authStore.js';
import SpinnerSvg from '../../Svg/SpinnerSvg.vue';

export default {
    name: 'Rating',
    components: { SpinnerSvg, WarningButton, LoadingSvg, SuccessButton, ModalCloseButton, DangerButton, ToolTip, StarSvg },
    props: {
        slug: String,
    },
    data() {
        return {
            authStore: useAuthStore(),
            dataUserAssessment: null,
            assessment: null,
            isRatingModalVisible: false,
            dataUserAssessmentLoading: true,
        };
    },
    methods: {
        getRatingData() {
            this.dataUserAssessmentLoading = true;
            axios
                .get(`/api/doramas/${this.slug}/rating`)
                .then((response) => {
                    if (response.data.data === null) {
                        this.dataUserAssessment = null;
                    } else {
                        this.dataUserAssessment = response.data.data.assessment;
                        this.assessment = this.dataUserAssessment;
                    }
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.dataUserAssessmentLoading = false;
                });
        },
        createOrUpdateDoramaRating() {
            this.dataUserAssessmentLoading = true;
            axios
                .post(`/api/doramas/rating`, {
                    slug: this.slug,
                    assessment: this.assessment,
                })
                .then((response) => {
                    this.dataUserAssessment = response.data.data.assessment;
                    this.toggleRatingModal();
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.dataUserAssessmentLoading = false;
                });
        },
        deleteDoramaRating() {
            this.dataUserAssessmentLoading = true;
            axios
                .delete(`/api/doramas/${this.slug}/rating`)
                .then((response) => {
                    this.dataUserAssessment = null;
                    this.assessment = null;
                    this.toggleRatingModal();
                    push.success(response.data);
                })
                .catch((error) => {
                    push.error(error.response.data);
                })
                .finally(() => {
                    this.dataUserAssessmentLoading = false;
                });
        },
        toggleRatingModal() {
            if (this.authStore.isAuthenticated) {
                this.isRatingModalVisible = !this.isRatingModalVisible;
                this.assessment = this.dataUserAssessment;
            } else {
                push.error('Необходимо авторизоваться!');
            }
        },
    },
    computed: {
        isRatingUser() {
            return this.dataUserAssessment !== null;
        },
        isDataRatingLoading() {
            return this.dataUserAssessmentLoading;
        },
    },
    mounted() {
        this.getRatingData();
    },
};
</script>

<template>
    <ToolTip
        message="Оценить"
        classes="py-2 px-4 bg-gray-600 text-yellow-500"
    >
        <button
            type="button"
            class="group flex cursor-pointer flex-row items-center rounded-sm bg-gray-700 p-2 hover:bg-gray-600"
            @click="toggleRatingModal"
            :disabled="isDataRatingLoading"
        >
            <SpinnerSvg
                v-if="isDataRatingLoading"
                classes="size-7 text-amber-400"
            />
            <StarSvg
                v-else
                :classes="['size-7 stroke-amber-400 group-hover:fill-amber-400', isRatingUser ? 'fill-amber-400' : 'fill-transparent']"
            />
        </button>
    </ToolTip>

    <teleport to="#modals">
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
                <div class="max-w-136 min-w-128 rounded-md bg-white shadow-xl select-none dark:bg-black">
                    <div class="flex items-center justify-between border-b border-gray-400 p-2">
                        <div class="mx-auto truncate pl-8 text-xl font-semibold text-black dark:text-white">Оценить</div>
                        <ModalCloseButton @click="toggleRatingModal" />
                    </div>

                    <div class="relative space-y-2 p-3 text-black dark:text-white">
                        <div
                            v-if="isDataRatingLoading"
                            class="absolute top-0 left-0 flex h-full w-full items-center justify-center bg-black/60"
                        >
                            <LoadingSvg classes="w-20 fill-violet-500" />
                        </div>

                        <div
                            v-if="isRatingUser"
                            class="w-full text-center text-lg"
                        >
                            Ваша оценка: {{ this.dataUserAssessment }}
                        </div>
                        <div
                            class="w-full text-center text-lg"
                            v-else
                        >
                            Вы не оценивали данное аниме
                        </div>

                        <div class="flex flex-row items-center justify-center text-xl">
                            <label
                                v-for="i in 10"
                                :key="i"
                                class="mx-1.5 flex cursor-pointer flex-col items-center"
                            >
                                <input
                                    :value="i"
                                    v-model="assessment"
                                    type="radio"
                                    name="rating"
                                    class="peer hidden"
                                />
                                <StarSvg classes="size-10 p-1 peer-checked:text-yellow-400 text-whiteActive dark:text-blackActive hover:text-red-400" />
                                <span> {{ i }} </span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-center border-t border-gray-400 p-2">
                        <WarningButton
                            v-if="isRatingUser"
                            text="Удалить"
                            @click="deleteDoramaRating"
                            :disabledButton="isDataRatingLoading"
                            class="mx-2"
                        />

                        <SuccessButton
                            :text="!isRatingUser ? 'Оценить' : 'Изменить'"
                            @click="createOrUpdateDoramaRating"
                            :disabledButton="isDataRatingLoading"
                            class="mx-2"
                        />

                        <DangerButton
                            text="Отмена"
                            @click="toggleRatingModal"
                            :disabledButton="isDataRatingLoading"
                            class="mx-2"
                        />
                    </div>
                </div>
            </div>
        </transition>
    </teleport>
</template>
