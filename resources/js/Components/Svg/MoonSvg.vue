<script>
export default {
    name: 'MoonSvg',
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
        viewBox="0 0 66 66"
        xmlns="http://www.w3.org/2000/svg"
    >
        <g
            stroke="none"
            stroke-width="1"
            fill="none"
            fill-rule="evenodd"
        >
            <g
                transform="translate(1.000000, 2.000000)"
                stroke-width="1"
            >
                <path
                    d="M48.7,45.8 C30.8,45.8 16.3,31.3 16.3,13.4 C16.3,8.6 17.3,4.1 19.2,0.1 C7.9,5.2 0.1,16.5 0.1,29.7 C0.1,47.6 14.6,62.1 32.5,62.1 C45.7,62.1 57,54.3 62.1,43 C57.9,44.8 53.4,45.8 48.7,45.8 L48.7,45.8 Z"
                    fill="#592be5"
                ></path>
                <path
                    fill="#ffcd40"
                    d="M28.7,1.8 L33.2,5.5 L38.8,4 L36.6,9.4 L39.8,14.3 L34,13.9 L30.3,18.4 L28.9,12.7 L23.5,10.7 L28.4,7.6 L28.7,1.8 Z"
                ></path>
                <path
                    fill="#ffcd40"
                    d="M49.5,22.5 L50.2,28.3 L55.4,31 L50.1,33.5 L49.2,39.2 L45.2,35 L39.4,35.9 L42.2,30.8 L39.6,25.6 L45.3,26.6 L49.5,22.5 Z"
                ></path>
                <path
                    fill="#ffcd40"
                    d="M56.7,3.8 L56.3,8.5 L59.9,11.6 L55.3,12.6 L53.5,17 L51.1,12.9 L46.4,12.6 L49.5,9 L48.3,4.4 L52.7,6.3 L56.7,3.8 Z"
                ></path>
            </g>
        </g>
    </svg>
</template>
