<script>
import Header from "../Components/Header.vue";

export default {
    name: "MainLayout",
    components: {Header}
}
</script>

<template>
    <Header/>
    <div class="h-14"></div>
    <RouterView/>
</template>
