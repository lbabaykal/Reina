import { defineStore } from 'pinia';

export const useThemeStore = defineStore('theme', {
    state: () => ({
        theme: 'system',
    }),
    actions: {
        toggleTheme() {
            if (this.theme === 'light') {
                this.theme = 'dark';
            } else if (this.theme === 'dark') {
                this.theme = 'system';
            } else {
                this.theme = 'light';
            }

            this.updateTheme();
        },

        syncTheme() {
            if (!localStorage.theme) {
                this.theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            this.updateTheme();
        },

        updateTheme() {
            if (this.theme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
            } else if (this.theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            // } else {
            //     document.documentElement.removeAttribute('data-theme');
            // }
            } else {
                document.documentElement.setAttribute('data-theme', window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (this.theme === 'system') {
                        document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
                    }
                });
            }
        },
    },
    getters: {
        isLight() {
            return this.theme === 'light';
        },
        isDark() {
            return this.theme === 'dark';
        },
    },
    persist: true,
});
