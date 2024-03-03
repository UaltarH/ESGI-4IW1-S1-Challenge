document.addEventListener("DOMContentLoaded", function () {
  const darkModeToggle = document.querySelector("#dark-mode-toggle");

  function applyDarkMode(enable) {
    const html = document.getElementsByTagName("html")[0];
    if (enable) {
      html.classList.add("dark");
    } else {
      html.classList.remove("dark");
    }
  }

  function loadDarkModePreference() {
    const darkMode = localStorage.getItem("darkMode");
    const isDarkMode = darkMode === "true";
    applyDarkMode(isDarkMode);

    darkModeToggle.checked = isDarkMode;
  }

  darkModeToggle.addEventListener("change", () => {
    const isDarkModeEnabled = darkModeToggle.checked;
    applyDarkMode(isDarkModeEnabled);
    localStorage.setItem("darkMode", isDarkModeEnabled);
  });

  loadDarkModePreference();
});
