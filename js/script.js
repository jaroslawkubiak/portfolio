"use strict";
import { arrowUp } from "./svgIcons.js";

//////////////////////////////////////////////////////////
// slider on me images
const meWrapper = document.querySelector(".me-wrapper");
document.querySelector(".me-slider").addEventListener("input", (e) => {
  meWrapper.style.setProperty("--position", `${e.target.value}%`);
});

window.addEventListener("load", () => {
  const loader = document.querySelector(".loader");
  loader.classList.add("loader-hidden");

  // start slider line moving
  let meSliderStart = 90;
  let sliderDirection = "left";
  const meSlider = function () {
    if (meSliderStart === 10 && sliderDirection === "left") {
      sliderDirection = "right";
    }
    if (meSliderStart === 90 && sliderDirection === "right") {
      clearInterval(meSliderInterval);
    }
    sliderDirection === "left" ? (meSliderStart -= 1) : (meSliderStart += 1);
    meWrapper.style.setProperty("--position", `${meSliderStart}%`);
  };
  const meSliderInterval = setInterval(meSlider, 10);
});

const burgerMenu = document.getElementById("burger");
const mobileMenu = document.getElementById("mobile-menu");

burgerMenu.addEventListener("click", () => {
  mobileMenu.classList.toggle("nav-hide");
});

const getWindowWidth = function () {
  return window.innerWidth;
};

//////////////////////////////////////////////////////////
// menu smooth navigation
document.getElementById("mobile-menu").addEventListener("click", function (e) {
  e.preventDefault();
  if (e.target.classList.contains("nav-link")) {
    const element = document.getElementById(e.target.hash.slice(1));
    // scrolling to section with class "section-to-reveal" has to be with shift in 300px. because section in revealing via css "section-hidden"
    let transformSectionToReveal = 0;

    // for pc view, when top menu is visible
    const windowWidth = getWindowWidth();
    if (windowWidth > 768) {
      if (element.id === "courses") transformSectionToReveal = 200;
      if (element.id === "skills") transformSectionToReveal = 70;
    } else {
      if (element.id === "courses") transformSectionToReveal = 100;
      if (element.id === "skills") transformSectionToReveal = 0;
    }
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

////////////////////////////////////////////////
// smooth scrolling animation
const allLinks = document.querySelectorAll("a");
allLinks.forEach((link) => {
  link.addEventListener("click", (e) => {
    const href = link.getAttribute("href");

    if (href !== "#" && href.startsWith("#")) {
      e.preventDefault();
      const sectionEl = document.querySelector(href);
      sectionEl.scrollIntoView({ behavior: "smooth" });
    }
  });
});

//////////////////////////////////////////////////////////
//menu fade animation
const nav = document.querySelector(".nav");
const hendleHover = function (e) {
  if (e.target.classList.contains("nav-link")) {
    const link = e.target;
    const siblings = link.closest(".nav").querySelectorAll(".nav-link");

    siblings.forEach((el) => {
      if (el !== link) el.style.opacity = this;
    });
  }
};
nav.addEventListener("mouseover", hendleHover.bind(0.5));
nav.addEventListener("mouseout", hendleHover.bind(1));

//////////////////////////////////////////////////////////
//sticky navigation observer API
const header = document.querySelector("header");
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
      "afterbegin",
      `<div class="arrow-go-up" id="goUp" title="Go to top">${arrowUp}</div>`
    );
}
document.addEventListener("scroll", () => {
  update();
  getWindowWidth();
});

//////////////////////////////////////////////////////////
// lazy loading img on portfolio sections
// get all section from portfolio
const portfolioTargets = document.querySelectorAll(".portfolio-preview");

// load high res image for visible portfolio section
const loadImg = function (entries, observer) {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;

    const portfolioLoading = document.getElementById(entry.target.id);
    const imgTargets = portfolioLoading.querySelectorAll("img[data-src]");

    imgTargets.forEach((img) => {
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
portfolioTargets.forEach((portfolio) => portfolioObserver.observe(portfolio));

//////////////////////////////////////////////////////////
// courses animation
const animateCoursesCircle = function () {
  const circularProgress = document.querySelectorAll(
    ".courses-item-circular-progress"
  );
  const progressValue = document.querySelectorAll(
    ".courses-item-progress-value"
  );
  const progressSpeeds = [5, 8, 12, 15, 18, 21, 25];

  // drawing circles for courses
  circularProgress.forEach((circle, index) => {
    let progressCounter = 0;

    // get percent from current course
    const progressEndValue = Number(progressValue[index].dataset["start"]);

    const shuffleIntervalTime = Math.floor(
      Math.random() * progressSpeeds.length
    );

    const progress = setInterval(() => {
      if (progressCounter === progressEndValue || !progressEndValue)
        clearInterval(progress);
      else if (progressEndValue) progressCounter++;

      progressValue[index].textContent = `${progressCounter}%`;
      circle.style.background = `conic-gradient(var(--accent-color) ${
        progressCounter * 3.6
      }deg, var(--lighter-primary-color) 0deg)`;
    }, progressSpeeds[shuffleIntervalTime]);
  });
};

//////////////////////////////////////////////////////////
// tech and soft skills animation
const animateTechSkillsPoints = function () {
  const skillPoint = document.querySelectorAll(".skill-point");
  skillPoint.forEach((point) => {
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
  let skillContainerHeight = window
    .getComputedStyle(skillContainer)
    .getPropertyValue("height");
  skillContainerHeight = Number(
    skillContainerHeight.substring(0, skillContainerHeight.length - 2)
  );
  const skillSoft = document.querySelectorAll(".skill-absolute");

  // calc value of one row height
  const rowHeight = Math.floor(skillContainerHeight / skillSoft.length);
  // start from 10 px minus row height top position
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
  roadMapItems.forEach((item) => {
    item.classList.add("road-map-container-animation");
  });
};

//////////////////////////////////////////////////////////
// Reveal sections
const allSections = document.querySelectorAll(".section-to-reveal");
const revealSection = function (entries, observer) {
  entries.forEach((entry) => {
    if (!entry.isIntersecting) return;

    entry.target.classList.remove("section-hidden");

    if (entry.target.id === "courses") animateCoursesCircle();
    if (entry.target.id === "tech-skills")
      setTimeout(animateTechSkillsPoints, 200);
    if (entry.target.id === "soft-skills") setTimeout(animateSoftSkills, 200);
    if (entry.target.id === "road-map") animateRoadMap();
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

// inserting copyright text with current year
const copyrightText = `Copyright &copy; ${new Date().getFullYear()} by Jarosław Kubiak`;
document.getElementById("copyright").innerHTML = copyrightText;
