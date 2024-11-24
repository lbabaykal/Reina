import {useAuthStore} from "../js/Stores/authStore.js";

export default function guest({ next }) {
    const authStore = useAuthStore();

    if (authStore.isAuthenticated) {
        return next({
            name: 'main',
        });
    }

    return next();
}
