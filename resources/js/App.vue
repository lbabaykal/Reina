<script>
import HeaderComponent from "@/Components/HeaderComponent.vue";

export default {
    name: "App",
    components: {HeaderComponent},
}

</script>

<template>
    <HeaderComponent/>

    <RouterView />
</template>

<style>

</style>
