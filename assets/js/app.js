const hamburgerToggler = document.querySelector(".navigation-toggler")
const navigationMenubar = document.querySelector(".navigation-menubar");

const toggleNav = () => {
  hamburgerToggler.classList.toggle("open")

  const ariaToggle = hamburgerToggler.getAttribute("aria-expanded") === "true" ?  "false" : "true";
  hamburgerToggler.setAttribute("aria-expanded", ariaToggle)

  navigationMenubar.classList.toggle("open")
}
hamburgerToggler.addEventListener("click", toggleNav)

new ResizeObserver(entries => {
  if(entries[0].contentRect.width <= 900){
    navigationMenubar.style.transition = "transform 0.3s ease-out"
  } else {
    navigationMenubar.style.transition = "none"
  }
}).observe(document.body)
