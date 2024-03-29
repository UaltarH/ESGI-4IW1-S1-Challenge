document.addEventListener("DOMContentLoaded", function () {
  const content = document.querySelector(".tableContent");

  if (content) {
    const itemsPerPage = 5;
    let currentPage = 0;
    const items = Array.from(content.getElementsByTagName("tr")).slice(1);

    function showPage(page) {
      const startIndex = page * itemsPerPage;
      const endIndex = startIndex + itemsPerPage;
      items.forEach((item, index) => {
        item.classList.toggle(
          "hidden",
          index < startIndex || index >= endIndex
        );
      });
      updateActiveButtonStates();
    }

    function createPageButtons() {
      const totalPages = Math.ceil(items.length / itemsPerPage);
      const paginationContainer = document.createElement("div");
      const paginationDiv = document.body.appendChild(paginationContainer);
      paginationContainer.classList.add("pagination");

      // Ajoute des boutons de page
      for (let i = 0; i < totalPages; i++) {
        const pageButton = document.createElement("button");
        pageButton.textContent = i + 1;
        pageButton.addEventListener("click", () => {
          currentPage = i;
          showPage(currentPage);
          updateActiveButtonStates();
        });

        content.appendChild(paginationContainer);
        paginationDiv.appendChild(pageButton);
      }
    }

    function updateActiveButtonStates() {
      const pageButtons = document.querySelectorAll(".pagination button");
      pageButtons.forEach((button, index) => {
        if (index === currentPage) {
          button.classList.add("active");
        } else {
          button.classList.remove("active");
        }
      });
    }

    const closeAlert = document.querySelector("#closeNotifFlush");
    if (closeAlert) {
      closeAlert.addEventListener("click", function () {
        const alert = document.querySelector("#alertFlushMessage");
        alert.classList.add("hidden");
      });
    }

    createPageButtons();
    showPage(currentPage);
  }
});
