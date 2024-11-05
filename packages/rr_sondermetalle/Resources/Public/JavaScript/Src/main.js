const header = document.querySelector("header");

window.addEventListener("scroll", function () {
  if (window.scrollY >= header.offsetHeight) {
    header.classList.add("fixed");
  } else {
    header.classList.remove("fixed");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const togglers = document.querySelectorAll(".caret-icon");
  togglers.forEach(function (toggle) {
    toggle.addEventListener("click", function (event) {
      event.stopPropagation();
      const nestedList = this.parentElement.querySelector(".nested");
      if (nestedList) {
        nestedList.classList.toggle("d-block");
        this.classList.toggle("caret-down");
      }
    });
  });
});
