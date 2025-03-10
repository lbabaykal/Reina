<script>
export default {
    name: "SortingSvg",
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
         viewBox="0 0 48 48"
         fill="none"
    >
        <rect width="48" height="48"/>
        <path d="M19 6L19 42" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M7 17.8995L19 5.89949" stroke="currentColor" stroke-width="4" stroke-linecap="round"
              stroke-linejoin="round"/>
        <path d="M29 42.1005L29 6.10051" stroke="currentColor" stroke-width="4" stroke-linecap="round"
              stroke-linejoin="round"/>
        <path d="M29 42.1005L41 30.1005" stroke="currentColor" stroke-width="4" stroke-linecap="round"
              stroke-linejoin="round"/>
    </svg>
</template>
