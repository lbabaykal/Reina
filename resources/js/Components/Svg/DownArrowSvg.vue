<script>
export default {
    name: "DownArrowSvg",
    props: {
        classes: {
            type: String,
            default: 'w-full h-full',
        },
    }
}
</script>

<template>
    <svg :class="classes"
         class="shrink-0"
         xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 17 17"
         fill="none"
         fill-rule="evenodd"
    >
        <path fill="currentColor" d="M2.16,6.246 C2.385,6.246 2.61,6.308 2.81,6.442 L9.039,10.598 L15.076,6.401 C15.617,6.042 16.346,6.188 16.705,6.729 C17.065,7.268 16.92,8 16.38,8.359 L9.692,12.989 C9.298,13.253 8.784,13.254 8.388,12.991 L1.508,8.402 C0.966,8.042 0.82,7.31 1.179,6.77 C1.407,6.429 1.78,6.246 2.16,6.246 L2.16,6.246 Z"/>
    </svg>
</template>
