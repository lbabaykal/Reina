<script>
import { RouterLink, RouterView } from 'vue-router';
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
