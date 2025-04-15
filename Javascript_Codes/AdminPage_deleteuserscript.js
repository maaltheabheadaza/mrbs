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

const deleteIcons = document.querySelectorAll('.delete-icon');

deleteIcons.forEach(icon => {
    icon.addEventListener('click', () => {

        const userId = icon.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this user?')) {
            fetch('../Php_Codes/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => {
                if (response.ok) {
                    document.getElementById('row' + userId).remove();
                    alert('User deleted successfully');
                    renumberRows();
                } else {
                    alert('Failed to delete user');
                }
            })

            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user');
            });
        }
    });
});

function renumberRows() {
    const rows = document.querySelectorAll('#userTable tr:not(:first-child)');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
    });
}