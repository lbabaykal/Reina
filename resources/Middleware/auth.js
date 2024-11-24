import {useAuthStore} from "../js/Stores/authStore.js";

export default function auth({ next }) {
    const authStore = useAuthStore();

    if (!authStore.isAuthenticated) {
        return next({
            name: 'login',
        });
    }

    return next();
}
