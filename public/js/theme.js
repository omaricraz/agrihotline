(function () {
    const root = document.documentElement;
    const stored = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const theme = stored || (prefersDark ? 'dark' : 'light');

    root.setAttribute('data-theme', theme);

    function updateIcon(current) {
        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            btn.innerHTML = current === 'dark'
                ? '<i class="bi bi-sun-fill"></i>'
                : '<i class="bi bi-moon-fill"></i>';
            btn.setAttribute('aria-label', current === 'dark' ? 'Switch to light mode' : 'Switch to dark mode');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateIcon(root.getAttribute('data-theme'));

        document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);
                updateIcon(next);
            });
        });
    });
})();
