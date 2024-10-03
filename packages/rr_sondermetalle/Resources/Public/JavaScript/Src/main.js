const header = document.querySelector("header");

window.addEventListener("scroll", function () {
  if (window.scrollY >= header.offsetHeight) {
    header.classList.add("fixed");
  } else {
    header.classList.remove("fixed");
  }
});
