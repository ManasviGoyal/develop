var sidebarOpen_1,sidebarToggleButton_1,sidebar_1,backdrop_1,mainNavigationLinks=document.getElementById("main-navigation-links"),openMainNavigationMenuIcon=document.getElementById("open-main-navigation-menu-icon"),closeMainNavigationMenuIcon=document.getElementById("close-main-navigation-menu-icon"),navigationToggleButton=document.getElementById("navigation-toggle-button"),themeToggleButtons=document.querySelectorAll(".theme-toggle-button"),navigationOpen=!1;function toggleNavigation(){(navigationOpen?hideNavigation:showNavigation)()}function showNavigation(){mainNavigationLinks.classList.remove("hidden"),openMainNavigationMenuIcon.style.display="none",closeMainNavigationMenuIcon.style.display="block",navigationOpen=!0}function hideNavigation(){mainNavigationLinks.classList.add("hidden"),openMainNavigationMenuIcon.style.display="block",closeMainNavigationMenuIcon.style.display="none",navigationOpen=!1}function toggleTheme(){"dark"===localStorage.getItem("color-theme")||!("color-theme"in localStorage)&&window.matchMedia("(prefers-color-scheme: dark)").matches?(document.documentElement.classList.remove("dark"),localStorage.setItem("color-theme","light")):(document.documentElement.classList.add("dark"),localStorage.setItem("color-theme","dark"))}function toggleSidebar(){function e(){sidebarOpen_1=!1,sidebar_1.classList.remove("active"),sidebarToggleButton_1.classList.remove("active"),backdrop_1.parentNode&&backdrop_1.parentNode.removeChild(backdrop_1),document.getElementById("content").classList.remove("sidebar-active")}sidebarOpen_1?e():(sidebarOpen_1=!0,sidebar_1.classList.add("active"),sidebarToggleButton_1.classList.add("active"),backdrop_1.id="sidebar-backdrop",backdrop_1.title="Click to close sidebar",backdrop_1.classList.add("backdrop"),backdrop_1.classList.add("active"),backdrop_1.addEventListener("click",e),document.body.appendChild(backdrop_1),document.getElementById("content").classList.add("sidebar-active"))}themeToggleButtons.forEach(function(e){e.addEventListener("click",toggleTheme)}),navigationToggleButton&&(navigationToggleButton.onclick=toggleNavigation),document.getElementById("lagrafo-app")&&(sidebarOpen_1=!1,sidebarToggleButton_1=document.getElementById("sidebar-toggle"),sidebar_1=document.getElementById("sidebar"),backdrop_1=document.createElement("div"),sidebarToggleButton_1.addEventListener("click",function(){toggleSidebar()}),document.addEventListener("keydown",function(e){sidebarOpen_1&&"Escape"===e.key&&toggleSidebar()}));