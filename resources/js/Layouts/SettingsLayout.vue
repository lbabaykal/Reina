<script>
import Menu from '../Components/Account/Settings/Menu.vue';


export default {
    name: 'SettingsLayout',
    components: { Menu },
};
</script>

<template>
    <section class="mt-5 flex items-center justify-center">
        <div class="flex flex-row">
            <Menu />

            <RouterView />
        </div>
    </section>
</template>
