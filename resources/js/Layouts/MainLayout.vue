<script>
import Header from "../Components/Header.vue";

export default {
    name: "MainLayout",
    components: {HeaderComponent: Header}
}
</script>

<template>
    <HeaderComponent/>

    <RouterView />
</template>
