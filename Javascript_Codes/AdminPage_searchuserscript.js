const sidebar = document.querySelector(".sidebar");
const sidebarClose = document.querySelector("#sidebar-close");
const menu = document.querySelector(".menu-content");
const menuItems = document.querySelectorAll(".submenu-item");
const subMenuTitles = document.querySelectorAll(".submenu .menu-title");

sidebarClose.addEventListener("click", () => sidebar.classList.toggle("close"));

menuItems.forEach((item, index) => {
  item.addEventListener("click", () => {
    menu.classList.add("submenu-active");
    item.classList.add("show-submenu");
    menuItems.forEach((item2, index2) => {
      if (index !== index2) {
        item2.classList.remove("show-submenu");
      }
    });
  });
});

subMenuTitles.forEach((title) => {
  title.addEventListener("click", () => {
    menu.classList.remove("submenu-active");
  });
});

const searchInput = document.getElementById('searchInput');
const rows = document.querySelectorAll('table tr');

function filterRows(searchText) {
rows.forEach((row, index) => {
if (index === 0) return; 
const cells = Array.from(row.cells).map(cell => cell.innerText.toLowerCase());
const match = cells.some(cellText => cellText.includes(searchText));
row.style.display = match ? '' : 'none';
});
}

searchInput.addEventListener('input', function() {
const searchText = this.value.toLowerCase().trim();
filterRows(searchText);
});

document.querySelector('.search-box a').addEventListener('click', function(event) {
event.preventDefault();
const searchText = searchInput.value.toLowerCase().trim(); 
filterRows(searchText);
});