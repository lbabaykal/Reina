<script>
export default {
    name: 'PlusSvg',
    props: {
        classes: {
            type: String,
            default: 'w-full h-full',
        },
    },
};
</script>

<template>
    <svg
        :class="classes"
        xmlns="http://www.w3.org/2000/svg"
        fill="currentColor"
        stroke="currentColor"
        viewBox="1 1 22 22"
        stroke-width="1.5"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4.5v15m7.5-7.5h-15"
        />
    </svg>
</template>
