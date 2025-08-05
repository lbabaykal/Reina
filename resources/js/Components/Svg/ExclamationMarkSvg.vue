<script>
export default {
    name: 'ExclamationMarkSvg',
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
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        stroke-width="1.5"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z"
        />
    </svg>
</template>
