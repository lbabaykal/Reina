<script>
import { Notivue, Notification, push, NotificationProgress } from 'notivue';

export default {
    name: "App",
    components: { Notivue, Notification, push, NotificationProgress }
}
</script>

<template>
    <RouterView />
    <Notivue v-slot="item">
        <Notification :item="item">
            <NotificationProgress :item="item" />
        </Notification>
    </Notivue>
</template>
