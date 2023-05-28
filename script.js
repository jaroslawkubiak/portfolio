"use strict";
import { svg, svgDemo, svgGithub, arrowRight, arrowLeft, arrowUp } from "./svg/svg-icons.js";

//////////////////////////////////////////////////////////
// slider on me images
const meWrapper = document.querySelector(".me-wrapper");
document.querySelector(".me-slider").addEventListener("input", e => {
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
const portfolioList = document.getElementById("portfolio-list");

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
        // console.log(windowWidth);
        if (windowWidth > 768) {
            // console.log("pc");
            if (element.id === "courses") transformSectionToReveal = 200;
            if (element.id === "skills") transformSectionToReveal = 70;
        } else {
            // console.log("mobile");
            if (element.id === "courses") transformSectionToReveal = 100;
            if (element.id === "skills") transformSectionToReveal = 0;
        }
        // console.log("transformSectionToReveal=", transformSectionToReveal);
        const y = element.getBoundingClientRect().top + window.scrollY - transformSectionToReveal;
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
        description: `<div>

        This is my main project for a client in the window manufacturing industry. It started with just two database tables and over 7 years of adding new functionalities, the system has now grown to include:
        <ul class="portfolio-panel-list">
        <li>warehouse, registration of orders to suppliers</li>
        <li>customer offers sent by email</li>
        <li>management of customer register</li>
        <li>management of the order register</li>
        <li>module for invoicing orders generated to PDF and sent by email</li>
        <li>recording of time and tasks of production employees</li>
        <li>transport orders with finished products</li>
        <li>detailed data analyses, and summaries that facilitate work planning </li>
        <li>detailed daily reports, automatically sent by email</li>
        <li>quotes for customers before orders are placed</li>
        <li>user management and a number of other settings: view of order columns, the numbering of documents, templates for sending emails</li>
        <li>separate login panel is available for customers to check the status of their orders</li>
        <li>separate login panel for drivers responsible for transporting orders</li>
        </ul>

        All functions were programmed as agreed upon and requested by the client. Before I started working on this system, the client was working on Excel tables, so most of the system is programmed on tables tags, basically copying the look and function to HTML.
        
        In this project, I used three external libraries:
        <ul class="portfolio-panel-list">
        <li>PHPMailer - to send emails with HTML content with attachments</li>
        <li>FPDF - for generating PDFs, e.g. invoices, order confirmations, quotes</li>
        <li>Signature Pad - for signing on the tablet by customers who pick up their order from the driver.</li>
        </ul></div>`,
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
        description: `<div>
            I'm a big fan and collector of Lego figures from the Star Wars series. When my collection grew to about 80 figures, 
            I needed a better way of cataloging it, something with pictures and better than Excel. Being a programmer, 
            I wrote a simple website (PHP and MySQL) where I could keep better track of which figurines are already in my 
            collection and I use this website till now. This project below, is the next version, written in JavaScript and React, 
            but not finished entirely. At the moment the database is contained in a JSON file, and once I learn Node.JS 
            I will be able to complete the project and replace the one written in PHP. I want to copy all the functions I 
            have in the current version such as sorting, statistics, and label generation to PDF. 
            <br />Hint: when adding new f
            igure type figure number from sw0001 to sw1267. Images are fetching from Lego DB.
            </div>`,
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
        description: `<div>
        One of my passions is traveling, With each trip I buy a patch with the flag of a particular country, which I then sew onto my backpack. I often play a quiz game on my phone where you have to guess the flags of different countries. I decided to write a similar game. During the JavaScript course, we used an API to get information about countries, so I used the same API to build this project. In my game, you can choose one or more continents from which you want to guess the flags of countries. You always have 10 flags to guess, drawn at random from the selected continents. The game remembers the best score in local storage.
        </div>`,
    },
    {
        title: "F1 - reflex game",
        link: "portfolio/f1",
        github: "https://github.com/jaroslawkubiak/reflex",
        imgDir: "f1",
        images: ["Your result", "Get ready", "Your result", "You click too soon"],
        tech: ["js", "html", "css"],
        description: `<div>
        Instagram's algorithm dropped me a video of Formula 1 driver Lando Norris testing his reflex, which is very important for a driver, especially during the start of a race. This inspired me to create a simple app where I could test my reaction speed and compare myself to an F1 driver. The average F1 driver's reaction speed is about 0.15 seconds, from the moment the start lights go off to the moment they press the accelerator. My app measures the time to the nearest 0.0001 seconds. Check your reflexes too.
        </div>`,
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
        description: `<div>
            I know, another Snake game project in JavaScript. Everyone does it, but this project is a good opportunity to practice JS and CSS. I wanted the game to have the feel of the one I remember from the Nokia 3310. You can play in portrait or landscape mode on a phone using gestures or on a PC using the arrow keys.
            </div>`,
    },
];

//////////////////////////////////////////////////////////
// map through portfolio array to create html
portfolio.forEach((item, index) => {
    let html = `
    <li class="portfolio-item-wrapper"  id="portfolio-${item.imgDir}"><article>
    <h6 class="portfolio-title">
    ${item.title}
    </h6>`;

    // portfolio description
    html += `<div class="portfolio-description-wrapper" >${item.description}</div>`;

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
        slides.forEach((s, i) => (s.style.transform = `translateX(${100 * (i - slide)}%)`));
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
    const circularProgress = document.querySelectorAll(".courses-item-circular-progress");
    const progressValue = document.querySelectorAll(".courses-item-progress-value");
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
            }deg, var(--lighter-primary-color) 0deg)`;
        }, progressSpeed);
    }); // 292f53
};

//////////////////////////////////////////////////////////
// tech and soft skills animation
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
    let skillContainerHeight = window.getComputedStyle(skillContainer).getPropertyValue("height");
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

        // console.log("widze=", entry.target.id);
        entry.target.classList.remove("section-hidden");

        if (entry.target.id === "courses") animateCoursesCircle();
        if (entry.target.id === "tech-skills") setTimeout(animateTechSkillsPoints, 200);
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
