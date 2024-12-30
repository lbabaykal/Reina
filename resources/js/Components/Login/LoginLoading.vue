<script>
import NoAvatarSvg from "../Svg/NoAvatarSvg.vue";

export default {
    name: "LoginLoading" ,
    components: {NoAvatarSvg}
}
</script>

<template>
    <div class="flex select-none flex-row transition-all duration-300 h-10 rounded-full bg-black/60 hover:bg-white/25">
        <div class="flex flex-col justify-center text-nowrap text-center">
            <div class="font-bold text-lg px-16">
                Loading...
            </div>
        </div>
        <NoAvatarSvg class="h-10 w-10 rounded-full bg-cover bg-center"/>
    </div>
</template>
