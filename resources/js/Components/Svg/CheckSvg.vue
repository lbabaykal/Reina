<script>
export default {
    name: 'CheckSvg',
    props: {
        classes: {
            type: [String, Array],
            default: 'w-full h-full',
        },
    },
};
</script>

<template>
    <svg
        :class="classes"
        class="shrink-0"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        stroke="currentColor"
        viewBox="1 1 22 22"
        stroke-width="1.5"
    >
        <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M19.7071 6.29289C20.0976 6.68342 20.0976 7.31658 19.7071 7.70711L10.4142 17C9.63316 17.7811 8.36683 17.781 7.58579 17L3.29289 12.7071C2.90237 12.3166 2.90237 11.6834 3.29289 11.2929C3.68342 10.9024 4.31658 10.9024 4.70711 11.2929L9 15.5858L18.2929 6.29289C18.6834 5.90237 19.3166 5.90237 19.7071 6.29289Z"
        />
    </svg>
</template>
