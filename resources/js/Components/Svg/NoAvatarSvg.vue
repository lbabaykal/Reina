<script>
export default {
    name: "NoAvatarSvg",
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
         class="fill-blue-400"
         viewBox="0 0 96 96"
         xmlns="http://www.w3.org/2000/svg"
    >
        <g>
            <g>
                <circle cx="48" cy="48" fill="" r="47.5"></circle>
            </g>
            <g>
                <g>
                    <path d="m48 24.3c-6.8 0-12.3 5.5-12.3 12.3s5.5 12.2 12.3 12.2 12.3-5.5 12.3-12.3-5.5-12.2-12.3-12.2z" fill="#fff"></path>
                </g>
                <g>
                    <path d="m56.6 51.7c-.8-.3-1.7 0-2.2.7l-6.4 8.8-6.4-8.7c-.5-.7-1.4-1-2.2-.7-8.8 2.9-14.8 9.9-15.2 17.9 0 .6.2 1.1.5 1.5.4.4.9.6 1.4.6h43.5c.5 0 1.1-.2 1.4-.6.4-.4.6-1 .5-1.5-.2-8.1-6.1-15.1-14.9-18z" fill="#fff"></path>
                </g>
            </g>
        </g>
    </svg>
</template>
