import { svg, svgDemo, svgGithub, arrowRight, arrowLeft } from "./svgIcons.js";
const portfolioList = document.getElementById("portfolio-list");

export const portfolio = [
  {
    title: "System for managing sets for a Interior Design Studio",
    link: "",
    github: [
      {
        name: "frontend",
        link: "https://github.com/jaroslawkubiak/zestawienia_frontend",
      },
      {
        name: "backend",
        link: "https://github.com/jaroslawkubiak/zestawienia_backend",
      },
    ],
    imgDir: "sets",
    images: [
      "Suppliers table",
      "Edit supplier modal",
      "Sets table, with sorting, paginations etc",
      "Detail position in set",
      "Action buttons - reorder position, add new, clone, delete",
      "Set as PDF file",
      "data base",
      "Notification after pasting image in position",
      "Notification after saving set header",
    ],
    tech: ["angular", "rxjs", "node", "nestjs", "mysql"],
    description: `This is my latest project for the interior design studio. 
    It start with end of <strong>february 2025</strong> and its evolving every day.
    Now, for every project design studio,o create a spreadsheet with a list of all products needed for the interior project. 
    This project is to make it easier for the client to track changes in the sets. 
        <ul class="portfolio-panel-list">
        <li>loging into the system</li>
        <li>managing clients and suppliers: CRUD operations. User can filter the client by name, company, email etc.</li>
        <li>managing sets for a client, with tracking of created (user and date) and update (user and date)</li>
        <li>set have different statuses to better track and filter a specific tab to check (kitchen, bathroom, living room etc)</li>
        <li>user can add new positions with product details to a specific tab</li>
        <li>user can paste a printscreen to set the position, and the image is immediately sent to the server</li>
        <li>user can fill up designated columns</li>
        <li>user can arrange the position order just by dragging and dropping the selected position to a new place</li>
        <li>user can clone existing position - for quicker entering data</li>
        <li>every column width in the set can be adjusted and saved independently </li>
        <li>set a unique link that can be sent as HTML by email to the client (no need to log in for the client)</li>
        <li>set can be converted to PDF file</li>
        <li>user can send additional files to set, ex moodboards, visualization and other PDF files</li>
        </ul>
        <br />
        Aside from Angular in the project I also use PrimeNG components.
        The project is still in development mode. Next steps on the todo list:
        <ul class="portfolio-panel-list">
        <li>sended email list with details</li>
        <li>client can add comments to every position, and user can answer on their comment</li>
        <li> sent email to suppliers with list of products</li>
        <li>different setting options like: email header, email content, default bookmarks</li>
        <li>and many more</li>
        </ul>
        There is no live demo yet. You can check GitHubs links.
        `,
  },
  {
    title: "Travel blog in WordpPress",
    link: "http://wp.jaroslawkubiak.pl",
    github: [],
    imgDir: ["wordpress"],
    images: [
      "Homepage",
      "Fresh from our blog section",
      "Europe travel",
      "Header menu",
      "Asia travel page",
      "Single post page",
      "Them builder",
      "Global settings",
    ],
    tech: ["wordpress", "html", "css"],
    description: `I am currently completing the Complete WordPress & Elementor Mastery Course (73% finished), 
    where I am learning to build modern, responsive websites using WordPress and Elementor.
    <br /><br />
    Course Scope and Skills Acquired:
    <ul class="portfolio-panel-list">
      <li>Installing and configuring WordPress on a private server</li>
      <li>Creating websites with Elementor (no coding required)</li>
      <li>Building responsive and visually appealing layouts</li>
      <li>Optimizing website speed and performance</li>
      <li>Developing online stores with WooCommerce</li>
      <li>SEO - optimizing content for search engines</li>
      <li>Managing WordPress themes and plugins</li>
    </ul>
    `,
  },

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
    description: `
          This is my main project <strong>for a client</strong> in the window joinery industry. 
          It all started with just two tables in the database. After 10 years of implementing new functionalities, the system includes:
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
  
          All functions were programmed as agreed upon and <strong>requested</strong> by the client. Before I started working on this system, the client was working on Excel tables, 
          so most of the system is programmed on tables tags, basically copying the look and function to HTML.
          
          <br /><br />I used three external libraries in the project:
          <ul class="portfolio-panel-list">
          <li>PHPMailer - to send emails with HTML content with attachments</li>
          <li>FPDF - for generating PDFs, e.g. invoices, order confirmations, quotes</li>
          <li>Signature Pad - for signing on the tablet by customers who pick up their order from the driver.</li>
          </ul>`,
  },
  {
    title: "Lego Star Wars Minifigure Collection",
    link: "portfolio/figures",
    github: [
      { name: "frontend", link: "https://github.com/jaroslawkubiak/figures" },
      {
        name: "backend",
        link: "https://github.com/jaroslawkubiak/figures-backend",
      },
    ],

    imgDir: "figures",
    images: [
      "Minifigure card view",
      "Add minifigure form with validation",
      "Expandable filters: number, name, year and series",
      "Edit minifigure form with delete option",
      "Comparasion of card view and R2D2 style view with more datail about figure",
      "Dropdown list in filters",
      "Modal windows with large preview of minifigure photo",
      "Notification when figure was eddited",
      "Notification when figure was removed",
    ],
    tech: ["react", "redux", "node", "express", "mysql"],
    description: `I am a huuuge fan and collector of <strong>Lego Star Wars</strong> minifigures. As my collection grew above 80 figures, 
    I needed a better way to catalog them, something where I could upload pictures, sort, and customize them to my needs. 
    As a <strong>programmer by passion</strong>, I wrote a simple website (PHP and MySQL) where I could better track which figures were already in my collection, and I use that website to this day. 
    The project below is the next version, written in <strong>React</strong>, Node.JS, and MySQL. The project has a few new features, such as:
        <ul class="portfolio-panel-list">
        <li>React fetch data from Node API, like: figure list etc.</li>
        <li>when entering 6-digic new figure number, program use Bricklink API (Oauth) for fetch figure data, like: name, additional, average price and release year</li>
        <li>when you submit a new figure, its photo will be downloaded to your computer and sent to FTP server</li>
        <li>when you delete figure from DB, its photo will also deleted from FTP server</li>
        <li>notification when adding, editing or deleting figure</li>
        </ul>
        Project is still in development. I want to copy all the functions have in the current version such as sorting, statistics, and label generation to PDF. You can test frontend side below.`,
  },
  {
    title: "Flag game",
    link: "portfolio/flags",
    github: [
      { name: "front", link: "https://github.com/jaroslawkubiak/flag-game" },
    ],
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
    description: `One of my passions is <strong>traveling</strong>, With each trip I buy a patch with the flag of a particular country, which I then sew onto my backpack. 
    I often play a quiz game on my phone where you have to guess the flags of different countries. I decided to write a similar game. During the <strong>JavaScript course</strong>, 
    we used an API to get information about countries, so I used the same API to build this project. In my game, you can choose one or more continents from which you want to guess the flags of countries. 
    You always have 10 flags to guess, drawn at random from the selected continents. The game remembers the best score in local storage.`,
  },
  {
    title: "F1 - reflex game",
    link: "portfolio/f1",
    github: [
      { name: "front", link: "https://github.com/jaroslawkubiak/reflex" },
    ],
    imgDir: "f1",
    images: ["Your result", "Get ready", "Your result", "You click too soon"],
    tech: ["js", "html", "css"],
    description: `Instagram's algorithm dropped me a video of Formula 1 driver Lando Norris testing his reflex, which is very important for a driver, especially during the start of a race. 
    This inspired me to create a simple app where I could test my reaction speed and compare myself to an F1 driver. The average F1 driver's reaction speed is about 0.15 seconds, 
    from the moment the start lights go off to the moment they press the accelerator. My app measures the time to the nearest 0.0001 seconds. Check your reflexes too.`,
  },
  {
    title: "Snake game",
    link: "portfolio/snake",
    github: [
      { name: "front", link: "https://github.com/jaroslawkubiak/snake" },
    ],
    imgDir: "snake",
    images: [
      "Game in mobile landscape view",
      "Game in mobile portrait view",
      "Game in PC",
      "Game over - best score is stored in browser memory",
    ],
    tech: ["js", "html", "css"],
    description: `I know, another Snake game project in JavaScript. Everyone does it, but this project is a good opportunity to practice JS and CSS. I wanted the game to have the feel of the one
     I remember from the Nokia 3310. You can play in portrait or landscape mode on a phone using gestures or on a PC using the arrow keys.`,
  },
];

//////////////////////////////////////////////////////////
// map through portfolio array to create html
portfolio.forEach((item) => {
  let html = `
      <li class="portfolio-item-wrapper" id="portfolio-${item.imgDir}"><article>
      <h2 class="portfolio-title">
      ${item.title}
      </h2>`;

  // portfolio description
  html += `<div class="portfolio-description-wrapper" >${item.description}</div>`;

  // portfolio tech stack
  html += `<div class="portfolio-tech">`;
  item.tech.forEach((tech) => (html += svg[tech]));
  html += `</div>`;

  // portfolio images
  html += `<div class="portfolio-preview" id="${item.imgDir}"><div class="portfolio-preview-images">`;

  for (let i = 0; i < item.images.length; i++) {
    html += `<div class="slide"><figure>
      <img src="/img/portfolio-preview/${item.imgDir}/${i + 1}.jpg" 
      alt="${item.images[i]}" title="${
      item.images[i]
    }" class="portfolio-preview-image" />
      <figcaption class="portfolio-image-caption">${item.images[i]}</figcaption>
      </figure></div>`;
  }

  html += `</div><button class="slider-btn slider-btn-left" aria-label="Slide image to left">${arrowLeft}</button>
    <button class="slider-btn slider-btn-right" aria-label="Slide image to right">${arrowRight}</button>`;
  html += `<div class="portfolio-preview-btn-dots"><div class="dots"></div>`;
  html += `</div></div>`;

  html += `<div class="portfolio-footer"><div class="portfolio-footer-github">`;
  if (item.github) {
    item.github.forEach((el) => {
      html += `<a href="${
        el.link
      }" target="_blank"><button class="portfolio-btn">${svgGithub}<p class="btn-text">GitHub ${
        el.name === "front" ? "" : el.name
      }</p></button></a>`;
    });
  }
  html += `</div>`;

  if (item.link !== "") {
    html += `<div class="portfolio-footer-demo">
    <a href="${item.link}" target="_blank">
    <button class="portfolio-btn">${svgDemo}<p class="btn-text">Live demo</p></button></a>
    </div>`;
  }

  html += `</div></article></li>`;

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
        `<button class="dots-dot" data-slide="${i}" aria-label="Dot symbolizing quantity of images"></button>`
      );
    });
  };

  // select active dot
  const activeDot = function (slide) {
    containerId
      .querySelectorAll(".dots-dot")
      .forEach((dot) => dot.classList.remove("dots-dot-active"));
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
    (e) => {
      startTouch = true;
      moveX = e.touches[0].clientX.toFixed(0);
      moveY = e.touches[0].clientY.toFixed(0);
    },
    { passive: false }
  );

  el.addEventListener(
    "touchmove",
    (e) => {
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
