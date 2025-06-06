

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

  document.querySelector(".box1").addEventListener("click", function() {
  document.getElementById("table1").style.display = "block";
  document.getElementById("table2").style.display = "none";
  document.getElementById("table3").style.display = "none";
});

document.querySelector(".box2").addEventListener("click", function() {
  document.getElementById("table1").style.display = "none";
  document.getElementById("table2").style.display = "block";
  document.getElementById("table3").style.display = "none";
});

document.querySelector(".box3").addEventListener("click", function() {
  document.getElementById("table1").style.display = "none";
  document.getElementById("table2").style.display = "none";
  document.getElementById("table3").style.display = "block";
});

document.addEventListener('DOMContentLoaded', function() {
    const sidebarAdmin = document.getElementById('sidebar-admin');
    const profileCard = document.querySelector('.profile-card');

    sidebarAdmin.addEventListener('mouseover', () => {
      profileCard.style.display = 'flex';
    });

    profileCard.addEventListener('mouseleave', () => {
      profileCard.style.display = 'none';
    });

    document.addEventListener('click', (event) => {
      if (!profileCard.contains(event.target) && !sidebarAdmin.contains(event.target)) {
        profileCard.style.display = 'none';
      }
    });
  });