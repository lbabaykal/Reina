<script>
export default {
    name: "SubscribeBackgroundSvg",
    props: {
        classes: {
            type: String,
            default: 'w-full h-full',
        },
    }
}
</script>

<template>
    <div>
        <svg :class="classes"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 252 60"
             fill="currentColor"
        >
            <g transform="translate(0,60) scale(0.1,-0.1)" stroke="none">
                <path d="M335 590 c-90 -19 -161 -67 -201 -137 -15 -26 -50 -72 -78 -100 l-50 -53 50 -52 c28 -29 63 -75 78 -101 32 -56 102 -110 166 -129 36 -10 245 -13 1020 -13 l975 0 47 24 c61 30 121 89 150 149 32 66 32 178 0 244 -29 60 -90 120 -150 150 l-47 23 -960 2 c-528 0 -978 -3 -1000 -7z" />
            </g>
        </svg>
    </div>
</template>
