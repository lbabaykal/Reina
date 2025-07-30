<script>
export default {
    name: 'ShieldSvg',
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
        viewBox="0 0 48 48"
        fill="currentColor"
        stroke="currentColor"
        stroke-width="1.5"
    >
        <path
            d="M24,2S6,7.1,6,8V26.2c0,9.2,13.3,17.3,17,19.5a1.8,1.8,0,0,0,2,0c3.8-2.1,17-10.3,17-19.5V8C42,7.1,24,2,24,2Zm9.4,16.4-11,11a1.9,1.9,0,0,1-2.8,0l-4.9-4.9a2.2,2.2,0,0,1-.4-2.7,2,2,0,0,1,3.1-.2L21,25.2l9.6-9.6a2,2,0,0,1,2.8,2.8Z"
        />
    </svg>
</template>
