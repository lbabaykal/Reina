<script>
import Header from "../Components/Header.vue";

export default {
    name: "ShowLayout",
    components: {Header}
}
</script>

<template>
    <Header/>

    <RouterView/>
</template>
