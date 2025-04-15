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

const sortTable = (table, column, asc) => {
const dirModifier = asc ? 1 : -1;
const tBody = table.tBodies[0];
const rows = Array.from(tBody.querySelectorAll("tr")).slice(1); 

const sortedRows = rows.sort((a, b) => {
const aVal = parseInt(a.cells[column].textContent.trim());
const bVal = parseInt(b.cells[column].textContent.trim());
return (aVal - bVal) * dirModifier;
});

rows.forEach(row => tBody.removeChild(row));

sortedRows.forEach(row => tBody.appendChild(row));
};

const table = document.querySelector("#userTable");

sortTable(table, 0, true);

const dropdown = document.querySelector(".dropdown-content");

dropdown.addEventListener("click", (e) => {
    e.preventDefault();
    if (e.target.tagName === "A") {
        const sortOrder = e.target.dataset.sort;

        if (sortOrder === "ascending") {
            sortTable(table, 0, true);
        } else if (sortOrder === "descending") {
            sortTable(table, 0, false);
        }
    }
});

document.querySelectorAll('.delete-row').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this booking?')) {
            const row = this.closest('tr');
            const id = this.dataset.id;
            fetch('../Php_Codes/delete_booking2.php?id=' + id, { method: 'DELETE' })
                .then(response => {
                    if (response.ok) {
                        row.remove();
                        alert('Booking deleted successfully!');

                        const rows = document.querySelectorAll('table tr');
                        rows.forEach((row, index) => {
                            if (index > 0) {
                                row.cells[0].textContent = index;
                            }
                        });
                    } else {
                        throw new Error('Failed to delete booking.');
                    }
                })
                .catch(error => alert(error.message));
        }
    });
});