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
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 16 16"
        fill="currentColor"
        stroke="currentColor"
    >
        <circle
            cx="8"
            cy="8"
            r="4"
        />
    </svg>
</template>
