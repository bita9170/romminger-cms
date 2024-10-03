const header = document.querySelector("header");
console.log(header, header.offsetHeight);

window.addEventListener("scroll", function () {
  if (window.scrollY >= header.offsetHeight) {
    header.classList.add("fixed");
  } else {
    header.classList.remove("fixed");
  }
});
