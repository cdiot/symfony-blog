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

window.onload = () => {
  let platform = document.querySelector("#article_form_platform");

  platform.addEventListener("change", function () {
      let form = this.closest("form")
      let data = this.name + "=" + this.value

      fetch(form.action, {
          method: form.getAttribute("method"),
          body: data,
          headers: {
              "Content-Type": "application/x-www-form-urlencoded; charset:UTF-8"
          }
      })
      .then(response => response.text())
      .then(html => {
          let content = document.createElement("html")
          content.innerHTML = html
          let newSelect = content.querySelector("#article_form_game")
          document.querySelector("#article_form_game").replaceWith(newSelect)
      })
  })
}

document.addEventListener('DOMContentLoaded', async () => {
  handleCommentForm();
});

const handleCommentForm = () => {
  if (null === document.querySelector('.comment-area')) {
      return;
  }

  const commentForm = document.querySelector('form.comment-form');

  commentForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const response = await fetch('/commentaires', {
          headers: {
              'X-Requested-With': 'XMLHttpRequest'
          },
          method: 'POST',
          body: new FormData(e.target)
      });

      if (!response.ok) {
          return;
      }

      const json = await response.json();

      if (json.code === 'COMMENT_ADDED_SUCCESSFULLY') {
          const commentsList = document.querySelector('.comment-list');
          const commentCount = document.querySelector('.comment-count');
          const commentFormContent = document.querySelector('#comment_form_content');
          commentsList.insertAdjacentHTML('beforeend', json.message);
          commentsList.lastElementChild.scrollIntoView();
          commentCount.innerText = json.numberOfComments;
          commentFormContent.value = '';
      }
  })
}
