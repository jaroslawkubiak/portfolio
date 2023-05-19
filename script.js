"use strict";
import {
  svg,
  svgDemo,
  svgGithub,
  arrowRight,
  arrowLeft,
  arrowUp,
} from "./svg/svg-icons.js";

const burgerMenu = document.getElementById("burger");
const mobileMenu = document.getElementById("mobile-menu");
const portfolioList = document.getElementById("portfolio-list");

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
    images: [
      "Production plan with orders to do",
      "Invoice table view and side menu left and right",
      "Invoice PDF preview",
      "Edit order form",
      "Edit evaluation of order",
      "Clients table and edit client form",
      "Construction drawings",
    ],
    tech: ["php", "mysql", "html", "css"],
    description: `This system is for a manufacturing company.
      Project is started with just two tables in data base: customer and orders. For over 7 years of adding new functionalities, the system has grow to:
      <ul>
        <li>•  warehouse, register of purchases and suppliers</li>
        <li>•  offers for customers sent by e-mail</li>
        <li>•  register of customers and orders (adding, editing and deleting)</li>
        <li>•  issuing invoices for orders + generating PDF with sending to e-mail</li>
        <li>•  implementation of the tasks of production employees</li>
        <li>•  transport orders </li>
        <li>•  detailed data analysis report to help you organize your work</li>
        <li>•  daily reports send by e-mail</li>
        <li>•  evaluation of orders for customers before their implementation</li>
        <li>•  management of users and a number of different settings: order list view, numbering, email templates</li>
        <li>•  separate login panel for client drivers and customers.</li>
      </ul>
      Everything is programmed as agreed with the client wish and design. Before i started work on this project, client work mostly in Excel, so all project is based on tables, basically copying excel sheets into html.
      In project I use couple external libraries: 
      <ul>
      <li>•  PHPMailer - for sending emails with attachments</li>
      <li>•  FPDF - for creating pdf files, ex: invoice and order confirmation</li>
      <li>•  Signature Pad - for the customer signed the receipt of the order</li>
      </ul>


      `,
  },
  {
    title: "Lego Star Wars Minifigure Collection",
    link: "portfolio/figures",
    github: "https://github.com/jaroslawkubiak/figures",
    imgDir: "figures",
    images: [
      "Minifigure card view",
      "Add minifigure form with validation",
      "Expandable filters: number, name, year and series",
      "Edit minifigure form with delete option",
      "Comparasion of card view and R2D2 style view with more datail about figure",
      "Dropdown list in filters",
      "Modal windows with large preview of minifigure photo",
    ],
    tech: ["js", "react", "redux"],
    description:
      "I'm a huge fan and collector of Lego Star Wars minifigures. When my collection had about 80 figures, I needed a better way to track down my collection, I needed something better than excel, something with images. Being a programmer, I wrote a web page (PHP & MySQL) for better track what's in my collection of the minifigures. Till today i use this web page. This application is the next version, mainly written for learning JS and React. At the moment the database is in a JSON file, when I finish the Node.JS course I will be able to finish this application. I want to copy all my feature from php version to Node.JS, including sorting, statistics and many more.",
  },

  {
    title: "Flag game",
    link: "portfolio/flags",
    github: "https://github.com/jaroslawkubiak/flag-game",
    imgDir: "flag",
    images: [
      "Select continent to start game",
      "You can start game",
      "Your answer is wrong",
      "Select answer (mobile landscape view)",
      "Your answer is corect (mobile portrait view)",
      "Your answer is wrong (mobile portrait view)",
      "Game over - view your score and game statistics",
    ],
    tech: ["js", "html", "css"],
    description:
      "I like to travel and collect patches of the flags of the countries I visit and sew them onto my backpack. On my phone i have game, where you have to guess country flag. I play it often. During JS course we use API for country information. Then i wanted to write similar game from my phone. You can choose one or more continent, and try to guess all country flag. You always have 10 flags, which are drawn from a pool of selected continents to guess, no matter if you select 1 or 6 continents.",
  },
  {
    title: "Snake game",
    link: "portfolio/snake",
    github: "https://github.com/jaroslawkubiak/snake",
    imgDir: "snake",
    images: [
      "Game in mobile landscape view",
      "Game in mobile portrait view",
      "Game in PC",
      "Game over - best score is stored in browser memory",
    ],
    tech: ["js", "html", "css"],
    description:
      "I know, i know. Another snake game project in JS 😁 Everyone does it. This project is great opportunity to learn JS. I wanted to program this nokia 3310 styled game for training JS and CSS skills. You can play on PC usign arrow key and 'a, w, s, d' keys. On mobile you play using touch controls, swiping in desired direction, both in portrait and landscape mode.",
  },
  {
    title: "F1 - reflex game",
    link: "portfolio/f1",
    github: "https://github.com/jaroslawkubiak/reflex",
    imgDir: "f1",
    images: ["Your result", "Get ready", "Your result", "You click too soon"],
    tech: ["js", "html", "css"],
    description:
      "Inspired by one of the videos on Instagram where F1 driver Lando Norris tests his reflexes. I want to have a similar app, so in two afternoons I wrote it. At the start of the race, the best F1 drivers have a score of around 0.15s from turning off the lights to pressing the throttle. This app measures your reflexes with an accuracy of 0.0001 seconds. See how fast you are. ",
  },
];

//////////////////////////////////////////////////////////
// map through portfolio array to create html
portfolio.forEach((item, index) => {
  let html = `
    <li class="portfolio-item-wrapper"><article>
    <h6 class="portfolio-title">
    ${item.title}
    </h6>
    <div class="portfolio-description-wrapper">`;

  // portfolio description
  html += `<p class="portfolio-description">${item.description}</p></div>`;

  // portfolio tech stack
  html += `<div class="portfolio-tech">`;
  item.tech.forEach(tech => (html += svg[tech]));
  html += `</div>`;

  //portfolio images
  html += `<div class="portfolio-preview" id="${item.imgDir}"><div class="portfolio-preview-images">`;

  for (let i = 0; i < item.images.length; i++) {
    html += `<div class="slide"><figure>
    <img src="/img/img-preview.jpg" 
    data-src="/img/portfolio-preview/${item.imgDir}/${i + 1}.jpg" 
    alt="${item.images[i]}" title="${
      item.images[i]
    }" class="portfolio-preview-image portfolio-lazy-img" />
    <figcaption class="portfolio-image-caption">${item.images[i]}</figcaption>
    </figure></div>`;
  }

  html += `</div><button class="slider-btn slider-btn-left">${arrowLeft}</button><button class="slider-btn slider-btn-right">${arrowRight}</button>`;
  html += `<div class="portfolio-preview-btn-dots"><div class="dots"></div>`;
  html += `</div></div>`;

  html += `<div class="portfolio-footer"><div class="portfolio-footer-github">`;
  if (item.github)
    html += `<a href="${item.github}" target="_blank"><button class="portfolio-btn">${svgGithub}<p class="btn-text">GitHub</p></button></a>`;
  html += `</div><div class="portfolio-footer-demo"><a href="${item.link}" target="_blank"><button class="portfolio-btn">${svgDemo}<p class="btn-text">Live demo</p></button></a></div>`;

  html += `</div></article></li>`;

  // if load last portfolio - don't put a <hr> tag
  if (index !== portfolio.length - 1) html += `<hr/>`;

  portfolioList.insertAdjacentHTML("beforeEnd", html);

  //////////////////////////////////////////////////////////
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
    curSlide = slide;
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
      goToSlide(Number(slide));
      activeDot(Number(slide));
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
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;

    const portfolioLoading = document.getElementById(entry.target.id);
    const imgTargets = portfolioLoading.querySelectorAll("img[data-src]");

    imgTargets.forEach(img => {
      // replace lazy img with high res img
      img.src = img.dataset.src;

      // remove blur effect(class) when img is finish loading
      img.addEventListener("load", () => {
        img.classList.remove("portfolio-lazy-img");
        observer.unobserve(entry.target);
      });
    });
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
// courses animation
const animateCoursesCircle = function () {
  const circularProgress = document.querySelectorAll(
    ".courses-item-circular-progress"
  );
  const progressValue = document.querySelectorAll(
    ".courses-item-progress-value"
  );
  const progressSpeed = 25;

  // drawing circles for courses
  circularProgress.forEach((circle, index) => {
    let progressCounter = 0;

    // get percent from current course
    const progressEndValue = Number(progressValue[index].dataset["start"]);

    const progress = setInterval(() => {
      progressCounter++;
      if (progressCounter === progressEndValue) clearInterval(progress);

      progressValue[index].textContent = `${progressCounter}%`;
      circle.style.background = `conic-gradient(var(--accent-color) ${
        progressCounter * 3.6
      }deg, #292f53 0deg)`;
    }, progressSpeed);
  });
};

//////////////////////////////////////////////////////////
// texh and soft skills animation
const animateTechSkillsPoints = function () {
  const skillPoint = document.querySelectorAll(".skill-point");
  skillPoint.forEach(point => {
    if (point.classList.contains("point-1")) {
      point.classList.add("point-move-1");
    }
    if (point.classList.contains("point-2")) {
      point.classList.add("point-move-2");
    }
    if (point.classList.contains("point-3")) {
      point.classList.add("point-move-3");
    }
    if (point.classList.contains("point-4")) {
      point.classList.add("point-move-4");
    }
    if (point.classList.contains("point-5")) {
      point.classList.add("point-move-5");
    }
  });
};
const animateSoftSkills = function () {
  // positioning soft skills
  const skillContainer = document.querySelector(".skills-soft");
  const skillContainerHeight = Number(
    window
      .getComputedStyle(skillContainer)
      .getPropertyValue("height")
      .slice(0, 3)
  );

  const skillSoft = document.querySelectorAll(".skill-absolute");

  // calc value of one row height
  const rowHeight = Math.floor(skillContainerHeight / skillSoft.length);

  // start from 10 px minus row heighttop position
  let topStart = 10 - rowHeight;

  skillSoft.forEach((skill, index) => {
    skill.classList.remove("skill-absolute");
    skill.classList.add("skill-relative");
    skill.style.right = "10px";

    topStart += rowHeight;
    skill.style.top = `${topStart}px`;
  });
};

//////////////////////////////////////////////////////////
// road map animation
const animateRoadMap = function () {
  const timeline = document.getElementById("road-map-timeline");
  const roadMapItems = document.querySelectorAll(".road-map-container");

  timeline.classList.add("road-map-line");
  roadMapItems.forEach(item => {
    item.classList.add("road-map-container-animation");
  });
};

//////////////////////////////////////////////////////////
// Reveal sections
const allSections = document.querySelectorAll(".section-to-reveal");
const revealSection = function (entries, observer) {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    entry.target.classList.remove("section-hidden");
    if (entry.target.id === "courses") animateCoursesCircle();
    if (entry.target.id === "tech-skills")
      setTimeout(animateTechSkillsPoints, 1000);
    if (entry.target.id === "soft-skills") setTimeout(animateSoftSkills, 1000);
    if (entry.target.id === "road-map") setTimeout(animateRoadMap, 500);
    observer.unobserve(entry.target);
  });
};

const sectionObserver = new IntersectionObserver(revealSection, {
  root: null,
  threshold: 0.15,
});

allSections.forEach(function (section) {
  sectionObserver.observe(section);
  section.classList.add("section-hidden");
});

//////////////////////////////////////////////////////////
// slider on me images
const meWrapper = document.querySelector(".me-wrapper");
document.querySelector(".me-slider").addEventListener("input", e => {
  meWrapper.style.setProperty("--position", `${e.target.value}%`);
});

//////////////////////////////////////////////////////////
// abotu me show more content
const aboutMeShowMore = document.getElementById("about-me-show-more");
aboutMeShowMore.addEventListener("click", () => {
  document.getElementById("about-me-more").classList.toggle("hidden-about-me");
  let showContent = aboutMeShowMore.innerHTML;
  switch (showContent) {
    case "show more...":
      aboutMeShowMore.innerHTML = "show less";
      break;
    case "show less":
      aboutMeShowMore.innerHTML = "show more...";
      break;
    default:
      break;
  }
});
