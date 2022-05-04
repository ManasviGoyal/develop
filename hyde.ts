/**
 * Core Scripts for the HydePHP Frontend
 *
 * @package     HydePHP - HydeFront
 * @version     v1.3.x (HydeFront)
 * @author      Caen De Silva
 */

const mainNavigationLinks = document.getElementById("main-navigation-links");
const openMainNavigationMenuIcon = document.getElementById("open-main-navigation-menu-icon");
const closeMainNavigationMenuIcon = document.getElementById("close-main-navigation-menu-icon");
const themeToggleButton = document.getElementById("theme-toggle-button");
const navigationToggleButton = document.getElementById("navigation-toggle-button");
const sidebarToggleButton = document.getElementById("sidebar-toggle-button");

let navigationOpen = false;

function toggleNavigation() {
    if (navigationOpen) {
        hideNavigation();
    } else {
        showNavigation();
    }
}

function showNavigation() {
    mainNavigationLinks.classList.remove("hidden");
    openMainNavigationMenuIcon.style.display = "none";
    closeMainNavigationMenuIcon.style.display = "block";

    navigationOpen = true;
}

function hideNavigation() {
    mainNavigationLinks.classList.add("hidden");
    openMainNavigationMenuIcon.style.display = "block";
    closeMainNavigationMenuIcon.style.display = "none";
    navigationOpen = false;
}

// Handle the documentation page sidebar

let sidebarOpen = screen.width >= 768;

const sidebar = document.getElementById("documentation-sidebar");
const backdrop = document.getElementById("sidebar-backdrop");

const toggleButtons = document.querySelectorAll(".sidebar-button-wrapper");

function toggleSidebar() {
    if (sidebarOpen) {
        hideSidebar();
    } else {
        showSidebar();
    }
}

function showSidebar() {
    sidebar.classList.remove("hidden");
    sidebar.classList.add("flex");
    backdrop.classList.remove("hidden");
    document.getElementById("app").style.overflow = "hidden";

    toggleButtons.forEach((button) => {
        button.classList.remove("open");
        button.classList.add("closed");
    });

    sidebarOpen = true;
}

function hideSidebar() {
    sidebar.classList.add("hidden");
    sidebar.classList.remove("flex");
    backdrop.classList.add("hidden");
    document.getElementById("app").style.overflow = null;

    toggleButtons.forEach((button) => {
        button.classList.add("open");
        button.classList.remove("closed");
    });

    sidebarOpen = false;
}

// Handle the theme switching

function toggleTheme() {
    if (isSelectedThemeDark()) {
        setThemeToLight();
    } else {
        setThemeToDark();
    }

    function isSelectedThemeDark() {
        return localStorage.getItem('color-theme') === 'dark' || !('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches;
    }

    function setThemeToDark() {
        document.documentElement.classList.add("dark");
        localStorage.setItem('color-theme', 'dark');
    }

    function setThemeToLight() {
        document.documentElement.classList.remove("dark");
        localStorage.setItem('color-theme', 'light');
    }
}

// Register onclick event listener for theme toggle button
themeToggleButton.onclick = toggleTheme;

// Register onclick event listener for navigation toggle button if it exists
if (navigationToggleButton) {
    navigationToggleButton.onclick = toggleNavigation;
}

// Register onclick event listener for sidebar toggle button if it exists
if (sidebarToggleButton) {
    sidebarToggleButton.onclick = toggleSidebar;
}
