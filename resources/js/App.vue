<script>
import { Notivue, Notification, push, NotificationProgress } from 'notivue';
import { useThemeStore } from './Stores/themeStore.js';
import { useAuthStore } from './Stores/authStore.js';

export default {
    name: 'App',
    components: { Notivue, Notification, push, NotificationProgress },
    data() {
        return {
            themeStore: useThemeStore(),
            authStore: useAuthStore(),
        };
    },
    mounted() {
        this.themeStore.syncTheme();
        this.authStore.getUser();
    },
};
</script>

<template>
    <RouterView />
    <Notivue v-slot="item">
        <Notification :item="item">
            <NotificationProgress :item="item" />
        </Notification>
    </Notivue>
</template>
