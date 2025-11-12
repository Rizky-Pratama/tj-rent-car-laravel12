document.addEventListener("alpine:init", () => {
    Alpine.data("themeManager", () => ({
        darkMode: false,
        sidebarOpen: false,

        initTheme() {
            // Read current state from DOM (set by inline blocking script)
            this.darkMode = document.documentElement.classList.contains("dark");

            // Check localStorage for consistency
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme) {
                this.darkMode = savedTheme === "dark";
            } else {
                // Fallback to system preference
                this.darkMode = window.matchMedia(
                    "(prefers-color-scheme: dark)"
                ).matches;
            }

            // Ensure DOM is in sync (should already be correct)
            this.syncThemeToDOM();

            // Watch for system theme changes
            this.watchSystemTheme();
        },

        /**
         * Toggle between light and dark mode
         */
        toggleTheme() {
            this.darkMode = !this.darkMode;
            this.syncThemeToDOM();
            this.saveThemePreference();
        },

        /**
         * Apply theme to DOM
         */
        syncThemeToDOM() {
            if (this.darkMode) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        },

        /**
         * Save theme preference to localStorage
         */
        saveThemePreference() {
            localStorage.setItem("theme", this.darkMode ? "dark" : "light");
        },

        /**
         * Watch for system theme changes (optional)
         */
        watchSystemTheme() {
            const mediaQuery = window.matchMedia(
                "(prefers-color-scheme: dark)"
            );

            // Only listen if no manual preference is saved
            mediaQuery.addEventListener("change", (e) => {
                if (!localStorage.getItem("theme")) {
                    this.darkMode = e.matches;
                    this.syncThemeToDOM();
                }
            });
        },
    }));
});
