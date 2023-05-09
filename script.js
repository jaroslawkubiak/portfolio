"use strict";
import {
  svg,
  svgDemo,
  svgGithub,
  arrowRight,
  arrowLeft,
  arrowUp,
} from "./svg/svg.js";

const burgerMenu = document.getElementById("burger");
const mobileMenu = document.getElementById("mobile-menu");
const portfolioList = document.getElementById("portfolio-list");

// force go to top page when refreshing
// window.onbeforeunload = function () {
//   window.scrollTo(0, 0);
// };

burgerMenu.addEventListener("click", () => {
  mobileMenu.classList.toggle("nav-hide");
});

//////////////////////////////////////////////////////////
// menu smooth navigation
document.getElementById("mobile-menu").addEventListener("click", function (e) {
  e.preventDefault();
  if (e.target.classList.contains("nav-link")) {
    const element = document.getElementById(e.target.hash.slice(1));
    // scrolling to section with class "section-to-reveal" has to be with shift in 300px. because section in revealing via css "section-hidden"
    let transformSectionToReveal = 0;
    if (element.classList.contains("section-to-reveal"))
      transformSectionToReveal = 300;

    console.log(transformSectionToReveal);
    const y =
      element.getBoundingClientRect().top +
      window.scrollY -
      transformSectionToReveal;
    window.scroll({
      top: y,
      behavior: "smooth",
    });

    mobileMenu.classList.add("nav-hide");
    burgerMenu.checked = false;
  }
});

//////////////////////////////////////////////////////////
//menu fade animation
const nav = document.querySelector(".nav");
const hendleHover = function (e) {
  if (e.target.classList.contains("nav-link")) {
    const link = e.target;
    const siblings = link.closest(".nav").querySelectorAll(".nav-link");

    siblings.forEach(el => {
      if (el !== link) el.style.opacity = this;
    });
  }
};
nav.addEventListener("mouseover", hendleHover.bind(0.5));
nav.addEventListener("mouseout", hendleHover.bind(1));

//////////////////////////////////////////////////////////
//sticky navigation observer API
const header = document.querySelector(".header");
const aboutMe = document.getElementById("about-me");
const stickyNav = function (entries) {
  const [entry] = entries;

  if (!entry.isIntersecting) header.classList.add("sticky");
  else header.classList.remove("sticky");
};

const headerObserver = new IntersectionObserver(stickyNav, {
  root: null,
  threshold: 0,
  rootMargin: "500px",
});
headerObserver.observe(aboutMe);

//////////////////////////////////////////////////////////
// portfolio array
const portfolio = [
  {
    title: "ERP System",
    link: "portfolio/panel",
    imgDir: "panel",
    images: 4,
    tech: ["php", "mysql", "html", "css"],
    description: `This system is for a manufacturing company.
      Project is started with jutr two tables in data base: customer and orders. For over 7 years of adding new functionalities, the system has grow to:
      <ul>
        <li>- warehouse, register of purchases and suppliers</li>
        <li>- offers for customers sent by e-mail</li>
        <li>- register of customers and orders (adding, editing and deleting)</li>
        <li>- issuing invoices for orders + generating PDF with sending to e-mail</li>
        <li>- implementation of the tasks of production employees</li>
        <li>- transport orders </li>
        <li>- detailed various data analysis reports</li>
        <li>- valuations for clients</li>
        <li>- daily reports</li>
        <li>- managing users and a number of different settings</li>
        <li>- separate login panel for drivers and customers.</li>
      </ul>
      Everything is programmed as agreed with the client wish.`,
  },
  {
    title: "Lego Star Wars Minifigure Collection",
    link: "portfolio/figures",
    github: "https://github.com/jaroslawkubiak/figures",
    imgDir: "figures",
    images: 3,
    tech: ["js", "react", "redux"],
    description:
      "I'm a huge fan and collector of Lego Star Wars minifigures. When my collection had about 80 figures I started to get a bit lost, I needed a better list (with images), something better than excel. Being a programmer, I wrote a web page with a database of my figures. For this day i use this web page. This application is the next version, mainly written for learning JS and React. At the moment the database is in a JSON file, when I finish the Node.JS course I will be able to finish this application.",
  },

  {
    title: "Flag game",
    link: "portfolio/flags",
    github: "https://github.com/jaroslawkubiak/flag-game",
    imgDir: "flag",
    images: 2,
    tech: ["js", "html", "css"],
    description:
      "Flag game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },
  {
    title: "Snake game",
    link: "portfolio/snake",
    github: "https://github.com/jaroslawkubiak/snake",
    imgDir: "snake",
    images: 1,
    tech: ["js", "html", "css"],
    description:
      " Snake game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },
  {
    title: "Pig game",
    link: "portfolio/pig",
    github: "https://github.com/jaroslawkubiak/pig-game",
    imgDir: "pig",
    images: 1,
    tech: ["js", "html", "css"],
    description:
      "Pig game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },

  {
    title: "F1 - reflex game",
    link: "portfolio/f1",
    github: "https://github.com/jaroslawkubiak/reflex",
    imgDir: "f1",
    images: 1,
    tech: ["js", "html", "css"],
    description:
      "Inspired by one of the videos on Instagram where F1 driver Lando Norris tests his reflexes. I want to have a similar app, so in two afternoons I wrote it. At the start of the race, the best F1 drivers have a score of around 0.15s from turning off the lights to pressing the throttle. This app measures your reflexes with an accuracy of 0.0001 seconds. See how fast you are. ",
  },
];

//////////////////////////////////////////////////////////
// map through portfolio array to create html
portfolio.forEach(item => {
  let html = `
    <li class="portfolio-item-wrapper"><article>
    <div class="portfolio-title">
    ${item.title}
    </div>
    <div class="portfolio-description-wrapper">
    <div class="portfolio-tech">`;

  // rendering portfolio
  item.tech.forEach(tech => (html += svg[tech]));

  html += `</div><div class="portfolio-description">${item.description}</div></div>`;

  html += `<div class="portfolio-preview" id="${item.imgDir}"><div class="portfolio-preview-images">`;

  for (let i = 1; i <= item.images; i++) {
    html += `<div class="slide">
    <img src="/portfolio/preview/low-res/${item.imgDir}/${i}.jpg" 
    data-src="/portfolio/preview/high-res/${item.imgDir}/${i}.jpg" 
    alt="Preview photo ${i}" class="portfolio-preview-image portfolio-lazy-img" /></div>`;
  }

  html += `</div><div class="portfolio-preview-btn-dots"><button class="slider-btn slider-btn-left">${arrowLeft}</button>
  <button class="slider-btn slider-btn-right">${arrowRight}</button>
  <div class="dots"></div>`;
  html += `</div></div>`;

  html += `<div class="portfolio-footer"><div class="portfolio-footer-github">`;
  if (item.github)
    html += `<a href="${item.github}" target="_blank"><span>${svgGithub}</span> <span>GitHub</span></a>`;
  html += `</div><div class="portfolio-footer-demo"><a href="${item.link}" target="_blank"><span>${svgDemo}</span> <span>Live demo</span></a></div>`;

  html += `</div></article></li>`;

  portfolioList.insertAdjacentHTML("beforeEnd", html);

  // slider effect
  const containerId = document.getElementById(item.imgDir);
  const slides = containerId.querySelectorAll(".slide");
  const btnLeft = containerId.querySelector(".slider-btn-left");
  const btnRight = containerId.querySelector(".slider-btn-right");
  const dotContainer = containerId.querySelector(".dots");
  let curSlide = 0;
  const maxSlide = slides.length;

  // creating dots under slider
  const createDots = function () {
    slides.forEach(function (_, i) {
      dotContainer.insertAdjacentHTML(
        "beforeend",
        `<button class="dots-dot" data-slide="${i}"></button>`
      );
    });
  };

  // select active dot
  const activeDot = function (slide) {
    containerId
      .querySelectorAll(".dots-dot")
      .forEach(dot => dot.classList.remove("dots-dot-active"));
    containerId
      .querySelector(`.dots-dot[data-slide="${slide}"]`)
      .classList.add("dots-dot-active");
  };

  // changing slides
  const goToSlide = function (slide) {
    slides.forEach(
      (s, i) => (s.style.transform = `translateX(${100 * (i - slide)}%)`)
    );
  };

  // first page load
  const init = function () {
    createDots();
    goToSlide(0);
    activeDot(0);
  };
  init();

  // next slide
  const nextSlide = function () {
    curSlide === maxSlide - 1 ? (curSlide = 0) : curSlide++;
    goToSlide(curSlide);
    activeDot(curSlide);
  };

  // previous slide
  const previousSlide = function () {
    curSlide === 0 ? (curSlide = maxSlide - 1) : curSlide--;
    goToSlide(curSlide);
    activeDot(curSlide);
  };

  // event handlers
  btnRight.addEventListener("click", nextSlide);
  btnLeft.addEventListener("click", previousSlide);

  // event listener for dots
  dotContainer.addEventListener("click", function (e) {
    if (e.target.classList.contains("dots-dot")) {
      const { slide } = e.target.dataset;
      goToSlide(slide);
      activeDot(slide);
    }
  });

  // swipe on images - changing slide
  let moveX;
  let moveY;
  let startTouch = false;
  const el = document.getElementById(item.imgDir);
  el.addEventListener(
    "touchstart",
    e => {
      startTouch = true;
      moveX = e.touches[0].clientX.toFixed(0);
      moveY = e.touches[0].clientY.toFixed(0);
    },
    { passive: false }
  );

  el.addEventListener(
    "touchmove",
    e => {
      if (!moveX || !moveY) {
        return;
      }

      let xDiff = moveX - e.touches[0].clientX.toFixed(0);
      let yDiff = moveY - e.touches[0].clientY.toFixed(0);

      if (Math.abs(xDiff) > Math.abs(yDiff) && startTouch) {
        if (xDiff > 0) nextSlide();
        else previousSlide();
      }
      startTouch = false;
    },
    { passive: false }
  );
});

//////////////////////////////////////////////////////////
// smooth go back to top of the page
function scrollUp() {
  window.scroll({ top: 0, behavior: "smooth" });
}

// update observer position
function update() {
  const pageBody = document.body;
  let positionFromTop = pageBody.getBoundingClientRect().y;
  const goUp = document.getElementById("goUp");

  //if btn exist in DOM - addevent
  if (goUp) goUp.addEventListener("click", scrollUp);

  //if scrooling up - remove btn
  if (goUp && positionFromTop > -1500) goUp.remove();

  // if scrool below 1500px - insert btn
  if (positionFromTop < -1500 && !goUp)
    pageBody.insertAdjacentHTML(
      "beforeend",
      `<div class="arrow-go-up" id="goUp" title="Go to top">${arrowUp}</div>`
    );
}
document.addEventListener("scroll", update);

//////////////////////////////////////////////////////////
// lazy loading img on portfolio sections
// get all section from portfolio
const portfolioTargets = document.querySelectorAll(".portfolio-preview");

// load high res image for visible portfolio section
const loadImg = function (entries, observer) {
  const [entry] = entries;

  if (!entry.isIntersecting) return;

  const portfolioLoading = document.getElementById(entry.target.id);
  const imgTargets = portfolioLoading.querySelectorAll("img[data-src]");

  imgTargets.forEach(img => {
    // replace lazy img with high res img
    img.src = img.dataset.src;

    // remove blur effect(class) when img is finish loading
    img.addEventListener("load", () =>
      img.classList.remove("portfolio-lazy-img")
    );
    observer.unobserve(entry.target);
  });
};

// create observer for each section in portfolio
const portfolioObserver = new IntersectionObserver(loadImg, {
  root: null,
  threshold: 0,
  rootMargin: "250px",
});

portfolioTargets.forEach(portfolio => portfolioObserver.observe(portfolio));

//////////////////////////////////////////////////////////
// Reveal sections
const allSections = document.querySelectorAll(".section-to-reveal");
const revealSection = function (entries, observer) {
  const [entry] = entries;

  if (!entry.isIntersecting) return;

  entry.target.classList.remove("section-hidden");
  observer.unobserve(entry.target);
};

const sectionObserver = new IntersectionObserver(revealSection, {
  root: null,
  threshold: 0.15,
});

allSections.forEach(function (section) {
  sectionObserver.observe(section);
  section.classList.add("section-hidden");
});
