console.log('Delete user script loaded');

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
console.log('Found delete icons:', deleteIcons.length);

deleteIcons.forEach(icon => {
    console.log('Adding click listener to icon:', icon);
    icon.style.cursor = 'pointer'; // Make sure cursor changes on hover
    
    icon.addEventListener('click', (e) => {
        console.log('Delete icon clicked');
        e.preventDefault();
        e.stopPropagation();

        const userId = icon.getAttribute('data-id');
        console.log('Attempting to delete user:', userId);

        if (confirm('Are you sure you want to delete this user?')) {
            fetch('Php_Codes/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('row' + userId).remove();
                    alert('User deleted successfully');
                    renumberRows();
                } else {
                    alert(data.message || 'Failed to delete user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user');
            });
        }
    });
});

const deleteButtons = document.querySelectorAll('.delete-btn');
console.log('Found delete buttons:', deleteButtons.length);

deleteButtons.forEach(button => {
    console.log('Adding click listener to button:', button);
    
    button.addEventListener('click', (e) => {
        console.log('Delete button clicked');
        e.preventDefault();
        e.stopPropagation();

        const userId = button.getAttribute('data-id');
        console.log('Attempting to delete user:', userId);

        if (confirm('Are you sure you want to delete this user?')) {
            fetch('Php_Codes/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('row' + userId).remove();
                    alert('User deleted successfully');
                    renumberRows();
                } else {
                    alert(data.message || 'Failed to delete user');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to delete user');
            });
        }
    });
});

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-row');
    
    // Add click event to each delete button
    deleteButtons.forEach(button => {
        button.onclick = function(e) {
            e.preventDefault();
            
            // Get the user ID from the data-id attribute
            const userId = this.getAttribute('data-id');
            
            // Show confirmation dialog
            if (confirm('Are you sure you want to delete this user?')) {
                // Send delete request
                fetch('delete_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove the row from the table
                        const rowToDelete = document.getElementById('row' + userId);
                        if (rowToDelete) {
                            rowToDelete.remove();
                            alert('User deleted successfully');
                        }
                    } else {
                        alert(data.message || 'Failed to delete user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete user');
                });
            }
        };
    });
});

function renumberRows() {
    const rows = document.querySelectorAll('#userTable tr:not(:first-child)');
    rows.forEach((row, index) => {
        row.cells[0].textContent = index + 1;
    });
}