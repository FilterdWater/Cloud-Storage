(function () {
    // Function to apply dark mode based on local storage or system preference
    const applyTheme = () => {
        const isDark = localStorage.theme === 'dark' ||
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);

        if (isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    applyTheme();

    // Listen for changes in system color scheme preferences
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);
})();
