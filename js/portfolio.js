import { svg, svgDemo, svgGithub, arrowRight, arrowLeft } from './svgIcons.js';
const portfolioList = document.getElementById('portfolio-list');

export const portfolio = [
    {
      title: 'ERP System',
      link: 'portfolio/panel',
      imgDir: 'panel',
      images: [
        'Production plan with orders to do',
        'Invoice table view and side menu left and right',
        'Invoice PDF preview',
        'Edit order form',
        'Edit evaluation of order',
        'Clients table and edit client form',
        'Construction drawings',
      ],
      tech: ['php', 'mysql', 'html', 'css'],
      description: `
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
          </ul>`,
    },
    {
      title: 'Lego Star Wars Minifigure Collection',
      link: 'portfolio/figures',
      github: [
        { name: 'frontend', link: 'https://github.com/jaroslawkubiak/figures' },
        { name: 'backend', link: 'https://github.com/jaroslawkubiak/figures-backend' },
      ],
  
      imgDir: 'figures',
      images: [
        'Minifigure card view',
        'Add minifigure form with validation',
        'Expandable filters: number, name, year and series',
        'Edit minifigure form with delete option',
        'Comparasion of card view and R2D2 style view with more datail about figure',
        'Dropdown list in filters',
        'Modal windows with large preview of minifigure photo',
        'Notification when figure was eddited',
        'Notification when figure was removed',
      ],
      tech: ['react', 'redux', 'node', 'express', 'mysql'],
      description: `I'm a big fan and collector of Lego figures from the Star Wars series. When my collection grew to about 80 figures, 
        I needed a better way of cataloging it, something with pictures and better than Excel. Being a programmer, 
        I wrote a simple website (PHP and MySQL) where I could keep better track of which figurines are already in my 
        collection and I use this website till now. This project below, is the next version, written in React, Node.JS and MySQL. Project has several new features, like:
        <ul class="portfolio-panel-list">
        <li>React fetch data from Node API, like: figure list etc.</li>
        <li>when entering 6-digic new figure number, program use Bricklink API (Oauth) for fetch figure data, like: name, additional, average price and release year</li>
        <li>when you submit a new figure, its photo will be downloaded to your computer and sent to FTP server</li>
        <li>when you delete figure from DB, its photo will also deleted from FTP server</li>
        <li>notification when adding, editing or deleting figure</li>
        </ul>
        Project is still in development. I want to copy all the functions have in the current version such as sorting, 
        statistics, and label generation to PDF.`,
    },
    {
      title: 'Flag game',
      link: 'portfolio/flags',
      github: [{ name: 'front', link: 'https://github.com/jaroslawkubiak/flag-game' }],
      imgDir: 'flag',
      images: [
        'Select continent to start game',
        'You can start game',
        'Your answer is wrong',
        'Select answer (mobile landscape view)',
        'Your answer is corect (mobile portrait view)',
        'Your answer is wrong (mobile portrait view)',
        'Game over - view your score and game statistics',
      ],
      tech: ['js', 'html', 'css'],
      description: `One of my passions is traveling, With each trip I buy a patch with the flag of a particular country, which I then sew onto my backpack. I often play a quiz game on my phone where you have to guess the flags of different countries. I decided to write a similar game. During the JavaScript course, we used an API to get information about countries, so I used the same API to build this project. In my game, you can choose one or more continents from which you want to guess the flags of countries. You always have 10 flags to guess, drawn at random from the selected continents. The game remembers the best score in local storage.`,
    },
    {
      title: 'F1 - reflex game',
      link: 'portfolio/f1',
      github: [{ name: 'front', link: 'https://github.com/jaroslawkubiak/reflex' }],
      imgDir: 'f1',
      images: ['Your result', 'Get ready', 'Your result', 'You click too soon'],
      tech: ['js', 'html', 'css'],
      description: `Instagram's algorithm dropped me a video of Formula 1 driver Lando Norris testing his reflex, which is very important for a driver, especially during the start of a race. This inspired me to create a simple app where I could test my reaction speed and compare myself to an F1 driver. The average F1 driver's reaction speed is about 0.15 seconds, from the moment the start lights go off to the moment they press the accelerator. My app measures the time to the nearest 0.0001 seconds. Check your reflexes too.`,
    },
    {
      title: 'Snake game',
      link: 'portfolio/snake',
      github: [{ name: 'front', link: 'https://github.com/jaroslawkubiak/snake' }],
      imgDir: 'snake',
      images: [
        'Game in mobile landscape view',
        'Game in mobile portrait view',
        'Game in PC',
        'Game over - best score is stored in browser memory',
      ],
      tech: ['js', 'html', 'css'],
      description: `I know, another Snake game project in JavaScript. Everyone does it, but this project is a good opportunity to practice JS and CSS. I wanted the game to have the feel of the one I remember from the Nokia 3310. You can play in portrait or landscape mode on a phone using gestures or on a PC using the arrow keys.`,
    },
  ];
  
  //////////////////////////////////////////////////////////
  // map through portfolio array to create html
  portfolio.forEach(item => {
    let html = `
      <li class="portfolio-item-wrapper"  id="portfolio-${item.imgDir}"><article>
      <h2 class="portfolio-title">
      ${item.title}
      </h2>`;
  
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
      <img src="/img/img-prev.webp" 
      data-src="/img/portfolio-preview/${item.imgDir}/${i + 1}.jpg" 
      alt="${item.images[i]}" title="${item.images[i]}" class="portfolio-preview-image portfolio-lazy-img" />
      <figcaption class="portfolio-image-caption">${item.images[i]}</figcaption>
      </figure></div>`;
    }
  
    html += `</div><button class="slider-btn slider-btn-left" aria-label="Slide image to left">${arrowLeft}</button>
    <button class="slider-btn slider-btn-right" aria-label="Slide image to right">${arrowRight}</button>`;
    html += `<div class="portfolio-preview-btn-dots"><div class="dots"></div>`;
    html += `</div></div>`;
  
    html += `<div class="portfolio-footer"><div class="portfolio-footer-github">`;
    if (item.github) {
      item.github.forEach(el => {
        html += `<a href="${
          el.link
        }" target="_blank"><button class="portfolio-btn">${svgGithub}<p class="btn-text">GitHub ${
          el.name === 'front' ? '' : el.name
        }</p></button></a>`;
      });
    }
  
    html += `</div><div class="portfolio-footer-demo"><a href="${item.link}" target="_blank"><button class="portfolio-btn">${svgDemo}<p class="btn-text">Live demo</p></button></a></div>`;
    html += `</div></article></li>`;
  
    portfolioList.insertAdjacentHTML('beforeEnd', html);
  
    //////////////////////////////////////////////////////////
    // slider effect
    const containerId = document.getElementById(item.imgDir);
    const slides = containerId.querySelectorAll('.slide');
    const btnLeft = containerId.querySelector('.slider-btn-left');
    const btnRight = containerId.querySelector('.slider-btn-right');
    const dotContainer = containerId.querySelector('.dots');
    let curSlide = 0;
    const maxSlide = slides.length;
  
    // creating dots under slider
    const createDots = function () {
      slides.forEach(function (_, i) {
        dotContainer.insertAdjacentHTML(
          'beforeend',
          `<button class="dots-dot" data-slide="${i}" aria-label="Dot symbolizing quantity of images"></button>`
        );
      });
    };
  
    // select active dot
    const activeDot = function (slide) {
      containerId.querySelectorAll('.dots-dot').forEach(dot => dot.classList.remove('dots-dot-active'));
      containerId.querySelector(`.dots-dot[data-slide="${slide}"]`).classList.add('dots-dot-active');
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
    btnRight.addEventListener('click', nextSlide);
    btnLeft.addEventListener('click', previousSlide);
  
    // event listener for dots
    dotContainer.addEventListener('click', function (e) {
      if (e.target.classList.contains('dots-dot')) {
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
      'touchstart',
      e => {
        startTouch = true;
        moveX = e.touches[0].clientX.toFixed(0);
        moveY = e.touches[0].clientY.toFixed(0);
      },
      { passive: false }
    );
  
    el.addEventListener(
      'touchmove',
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