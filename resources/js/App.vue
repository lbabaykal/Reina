<script>
import { Notivue, Notification, push, NotificationProgress } from 'notivue';
import { useThemeStore } from './Stores/themeStore.js';
import { useAuthStore } from './Stores/authStore.js';
import { useFoldersStore } from './Stores/foldersStore.js';

export default {
    name: 'App',
    components: { Notivue, Notification, push, NotificationProgress },
    data() {
        return {
            themeStore: useThemeStore(),
            authStore: useAuthStore(),
            foldersStore: useFoldersStore(),
        };
    },
    mounted() {
        this.themeStore.syncTheme();
        this.authStore.getUser();
        if (this.authStore.isAuthenticated && (localStorage.getItem('folders') === null)) {
            this.foldersStore.getFolders();
        }
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
