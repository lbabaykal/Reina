<script>
export default {
    name: "YandexLogoSvg",
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
         viewBox="0 0 64 64"
         fill='none'
         xmlns='http://www.w3.org/2000/svg'>
        <circle cx='32' cy='32' r='32' fill='#FC3F1D'/>
        <path d='M37.02 52h6.977V12H33.842c-10.213 0-15.57 5.228-15.57 12.951 0 6.667 3.473 10.426 9.625 14.509l3.738 2.467-4.798-4.024L17.33 52h7.564L35.05 36.846l-3.532-2.35c-4.268-2.878-6.358-5.11-6.358-9.956 0-4.258 3.003-7.136 8.712-7.136h3.12V52h.03z' fill='#fff'/>
    </svg>
</template>
