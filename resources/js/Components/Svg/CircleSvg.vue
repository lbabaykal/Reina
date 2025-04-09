<script>
export default {
    name: 'CircleSvg',
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
        class="shrink-0"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 18 18"
        fill="currentColor"
        stroke="currentColor"
    >
        <circle
            cx="9"
            cy="9"
            r="5"
        />
    </svg>
</template>
