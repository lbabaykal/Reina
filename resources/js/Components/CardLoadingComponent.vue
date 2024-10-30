<script>
export default {
    name: "CardLoadingComponent",
}
</script>

<template>
    <div class="relative select-none w-full h-full aspect-[5/7] flex items-center justify-center">
        <div class="overflow-hidden rounded-md w-95% aspect-[5/7] transition-all duration-500">
            <div class="w-full h-full bg-gradient-to-r from-gray-900 via-gray-700 to-gray-900 bg-[length:300%_100%] animate-shine">
            </div>
        </div>
    </div>
</template>
