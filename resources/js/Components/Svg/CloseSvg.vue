<script>
export default {
    name: "CloseSvg",
    props: {
        classes: {
            type: [String, Array],
            default: 'w-full h-full',
        },
    }
}
</script>

<template>
    <svg :class="classes"
         xmlns="http://www.w3.org/2000/svg"
         fill="currentColor"
         stroke="currentColor"
         viewBox="1 1 22 22"
    >
        <path
            d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/>
    </svg>
</template>
