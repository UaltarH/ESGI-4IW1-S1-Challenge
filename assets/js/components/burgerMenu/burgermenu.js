document.addEventListener("DOMContentLoaded", function () {
  // main menu toggle
  const mainNav = document.querySelector(".main-nav ul");
  const burger = document.querySelector(".menu-burger");

  burger.addEventListener("click", () => {
    mainNav.classList.toggle("sm:-left-full");
  });

  const darkModeToggle = document.querySelector("#dark-mode-toggle");
  darkModeToggle.addEventListener("change", () => {
    if (darkModeToggle.checked) {
      document.getElementsByTagName("html")[0].classList.add("dark");
    } else {
      document.getElementsByTagName("html")[0].classList.remove("dark");
    }
  });
});
