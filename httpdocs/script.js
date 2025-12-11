
// Mobile menu toggle
const toggle = document.getElementById("menu-toggle");
const menu = document.getElementById("nav-menu");

toggle.addEventListener("click", () => {
  menu.classList.toggle("active");
});

function toggleMenu() {
    document.getElementById("nav-menu").classList.toggle("active");
}

function goBack() {
  window.location.href = "index.html"; // redirect to your main page
}

document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();
  alert("Login successful! Redirecting...");
  // add your login validation or redirect logic here
});

document.querySelector("form").addEventListener("submit", function(e) {
    e.preventDefault();
    window.location.href = "success.html";
});
