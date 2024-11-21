const profileBtn = document.getElementById("profile-btn");
const dropdownMenu = document.getElementById("dropdown-menu");

// Toggle dropdown menu on button click
profileBtn.addEventListener("click", () => {
  dropdownMenu.classList.toggle("hidden");
});

// Close dropdown when clicking outside
window.addEventListener("click", (event) => {
  if (!profileBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
    dropdownMenu.classList.add("hidden");
  }
});
