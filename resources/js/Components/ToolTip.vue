<script>
export default {
    name: "ToolTip",
    props: {
        message: {
            type: String,
            default: '',
        },
        classes: {
            type: [String, Array],
            default: '',
        },
    },
    data() {
        return {

        }
    },
}

</script>

<template>
    <div class="group relative flex">
        <span class="absolute text-nowrap rounded -bottom-10 left-1/2 -translate-x-1/2 opacity-0 scale-95 translate-y-5 pointer-events-none z-30
                    transition-all ease-in-out duration-300 group-hover:opacity-100 group-hover:scale-100 group-hover:translate-y-0 group-hover:pointer-events-auto"
              :class="classes"
        >
            {{ message }}
        </span>
        <slot></slot>
    </div>
</template>
