let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides((slideIndex += n));
}

function currentSlide(n) {
  showSlides((slideIndex = n));
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slides.length;
  }
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}
// ---------------------------------Job List ----------------------------------------------
//$(document).ready(function() {
//$('.search-box').focus();
//});

const wrapper = document.querySelector(".wrapper");
const header = document.querySelector(".header");

const toggleButton = document.querySelector(".dark-light");

toggleButton.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
});

const jobCards = document.querySelectorAll(".job-card");
const logo = document.querySelector(".logo");
const jobLogos = document.querySelector(".job-logos");
const jobDetailTitle = document.querySelector(
  ".job-explain-content .job-card-title"
);
const jobBg = document.querySelector(".job-bg");

jobCards.forEach((jobCard) => {
  jobCard.addEventListener("click", () => {
    const number = Math.floor(Math.random() * 10);
    const url = `https://unsplash.it/640/425?image=${number}`;
    jobBg.src = url;

    const logo = jobCard.querySelector("svg");
    const bg = logo.style.backgroundColor;
    // console.log(bg);
    jobBg.style.background = bg;
    const title = jobCard.querySelector(".job-card-title");
    jobDetailTitle.textContent = title.textContent;
    jobLogos.innerHTML = logo.outerHTML;
    wrapper.classList.add("detail-page");
    wrapper.scrollTop = 0;
  });
});

logo.addEventListener("click", () => {
  wrapper.classList.remove("detail-page");
  wrapper.scrollTop = 0;
  jobBg.style.background = bg;
});
