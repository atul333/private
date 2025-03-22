// Theme toggle functionality
function toggleTheme() {
    const html = document.documentElement;
    const themeIcon = document.getElementById('theme-icon');
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? null : 'dark';

    // Toggle theme
    html.setAttribute('data-theme', newTheme);
    
    // Update icon
    themeIcon.classList.remove('fa-sun', 'fa-moon');
    themeIcon.classList.add(newTheme === 'dark' ? 'fa-moon' : 'fa-sun');

    // Save preference
    localStorage.setItem('theme', newTheme);
}

// Initialize theme on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const themeIcon = document.getElementById('theme-icon');
    
    if (savedTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');
    }
});