"use strict";
import { svg, svgDemo, svgGithub } from "./svg.js";

const burgerMenu = document.getElementById("burger");
const mobileMenu = document.getElementById("mobile-menu");
const portfolioList = document.getElementById("portfolio-list");

burgerMenu.addEventListener("click", () => {
  mobileMenu.classList.toggle("hidden");
});

const portfolio = [
  {
    title: "ERP System",
    link: "portfolio/panel",
    img: "panel.jpg",
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
    img: "figures.jpg",
    tech: ["react", "redux", "js"],
    description:
      "I'm a huge fan and collector of Lego Star Wars minifigures. When my collection had about 80 figures I started to get a bit lost, I needed a better list (with images), something better than excel. Being a programmer, I wrote a web page with a database of my figures. For this day i use this web page. This application is the next version, mainly written for learning JS and React. At the moment the database is in a JSON file, when I finish the Node.JS course I will be able to finish this application.",
  },

  {
    title: "Flag game",
    link: "portfolio/flags",
    github: "https://github.com/jaroslawkubiak/flag-game",
    img: "flag.jpg",
    tech: ["js", "html", "css"],
    description:
      "Flag game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },
  {
    title: "Snake game",
    link: "portfolio/snake",
    github: "https://github.com/jaroslawkubiak/snake",
    img: "snake.jpg",
    tech: ["js", "html", "css"],
    description:
      " Snake game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },
  {
    title: "Pig game",
    link: "portfolio/pig",
    github: "https://github.com/jaroslawkubiak/pig-game",
    img: "pig.jpg",
    tech: ["js", "html", "css"],
    description:
      "Pig game Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam eu velit egestas, ultrices nisl vel, porta ipsum. Maecenas maximus felis a efficitur maximus. Sed elementum nisl lectus, a molestie tellus hendrerit in. Duis egestas velit et metus scelerisque, at placerat ipsum luctus. Duis auctor auctor ex, vel fringilla est pharetra a.",
  },

  {
    title: "F1 - reflex game",
    link: "portfolio/f1",
    github: "https://github.com/jaroslawkubiak/reflex",
    img: "f1.jpg",
    tech: ["js", "html", "css"],
    description:
      "Inspired by one of the videos on Instagram where F1 driver Lando Norris tests his reflexes. I want to have a similar app, so in two afternoons I wrote it. At the start of the race, the best F1 drivers have a score of around 0.15s from turning off the lights to pressing the throttle. This app measures your reflexes with an accuracy of 0.0001 seconds. See how fast you are. ",
  },
];

portfolio.map(item => {
  let html = `
    <li class="portfolio-item-wrapper">
    <div class="portfolio-title">
    ${item.title}
    </div>
    <div class="portfolio-description-wrapper">
    <div class="portfolio-tech">`;

  // rendering portfolio
  item.tech.map(tech => (html += svg[tech]));

  html += `</div><div class="portfolio-description">${item.description}</div></div>`;

  html += `<div class="portfolio-preview">`;
  html += `<img src="/portfolio/preview/${item.img}" class="portfolio-preview-image" alt="Preview" /></div>`;

  html += `<div class="portfolio-footer"><div class="portfolio-footer-github">`;
  if (item.github)
    html += `<a href="${item.github}" target="_blank"><span>${svgGithub}</span> <span>GitHub</span></a>`;
  html += `</div><div class="portfolio-footer-demo"><a href="${item.link}" target="_blank"><span>${svgDemo}</span> <span>Live demo</span></a></div></div>`;

  html += `</div></li>`;

  portfolioList.insertAdjacentHTML("beforeEnd", html);
});

// menu smooth navigation
document.getElementById("mobile-menu").addEventListener("click", function (e) {
  e.preventDefault();
  if (e.target.classList.contains('nav-link')) {
    const id = e.target.getAttribute('href');
    document.querySelector(id).scrollIntoView({ behavior: 'smooth' });
  }
});
