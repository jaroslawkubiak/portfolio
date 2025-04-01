const coursesContainer = document.getElementById("coursesList");

export const coursesList = [
  {
    name: "Wordpress & Elementor Mastery 2025 - Learn To Build Websites",
    percent: 73,
    udemy:
      "https://www.udemy.com/course/complete-wordpress-elementor-mastery-course/",
    pdf: "",
    time: "20h",
    language: "ENG",
  },
  {
    name: `Typescript: The Complete Developer's Guide`,
    percent: 100,
    udemy:
      "https://www.udemy.com/course/typescript-the-complete-developers-guide/",
    pdf: "certificates/typescript.pdf",
    time: "27h",
    language: "ENG",
  },
  {
    name: "Angular - The Complete Guide",
    percent: 100,
    udemy: "https://www.udemy.com/course/the-complete-guide-to-angular-2",
    pdf: "certificates/angular.pdf",
    time: "55,5h",
    language: "ENG",
  },
  {
    name: "RxJS 101",
    percent: 100,
    udemy: "https://www.udemy.com/course/rxjs-101-course/",
    pdf: "certificates/rxjs.pdf",
    time: "5,5h",
    language: "ENG",
  },
  {
    name: "NestJS: The Complete Developer's Guide",
    percent: 100,
    udemy: "https://www.udemy.com/course/nestjs-the-complete-developers-guide/",
    pdf: "certificates/nestjs.pdf",
    time: "19,5h",
    language: "ENG",
  },
  {
    name: "Node.js, Express, MongoDB & More. The Complete Bootcamp",
    percent: 100,
    udemy: "https://www.udemy.com/course/nodejs-express-mongodb-bootcamp/",
    pdf: "certificates/nodejs.pdf",
    time: "42h",
    language: "ENG",
  },
  {
    name: "The Complete JavaScript Course 2023. From Zero to Expert!",
    percent: 100,
    udemy: "https://www.udemy.com/course/the-complete-javascript-course/",
    pdf: "certificates/javascript.pdf",
    time: "69h",
    language: "ENG",
  },
  {
    name: "Modern React with Redux [2023 Update]",
    percent: 100,
    udemy: "https://www.udemy.com/course/react-redux/",
    pdf: "certificates/react-redux.pdf",
    time: "37,5h",
    language: "ENG",
  },
  {
    name: "The Ultimate React Course 2023: React, Redux & More",
    percent: 48,
    udemy: "https://www.udemy.com/course/the-ultimate-react-course/",
    pdf: "certificates/.pdf",
    time: "67h",
    language: "ENG",
  },
  {
    name: "Build Responsive Real-World Websites with HTML and CSS",
    percent: 100,
    udemy:
      "https://www.udemy.com/course/design-and-develop-a-killer-website-with-html5-and-css3/",
    pdf: "certificates/build-responsive-real-world-websites.pdf",
    time: "37,5h",
    language: "ENG",
  },
  {
    name: "Advanced CSS and Sass: Flexbox, Grid, Animations and More!",
    percent: 54,
    udemy: "https://www.udemy.com/course/advanced-css-and-sass/",
    pdf: "certificates/.pdf",
    time: "28h",
    language: "ENG",
  },
  {
    name: "Web Design for Web Developers. Build Beautiful Websites!",
    percent: 100,
    udemy: "https://www.udemy.com/course/web-design-secrets/",
    pdf: "",
    time: "3,5h",
    language: "ENG",
  },
  {
    name: "Wprowadzenie do Git i GitHub",
    percent: 100,
    udemy: "https://www.udemy.com/course/kurs-git-i-github-od-podstaw/",
    pdf: "",
    time: "5h",
    language: "PL",
  },
  {
    name: "Python dla początkujących",
    percent: 100,
    udemy: "https://www.udemy.com/course/python-dla-poczatkujacych/",
    pdf: "certificates/python.pdf",
    time: "6,5h",
    language: "PL",
  },
];

coursesList.forEach((item, index) => {
  const complete = item.percent === 100 ? true : false;
  const certificate = item.pdf === "" ? true : false;

  let html = `
    <li class="courses-item-wrapper">
        <div class="courses-item-circular-progress" title="${
          complete ? "Done" : "In progress"
        }">
            <span class="courses-item-progress-value" data-start="${
              item.percent
            }"></span>
        </div>
        <div class="courses-item-title">
            <a href="${
              item.udemy
            }" target="_blank" title="View course details">${item.name}</a>
        </div>
        <div class="courses-time">${item.time}</div>
        <div class="courses-language">${item.language}</div>`;

  if (certificate) {
    html += ` <div class="courses-item-link courses-no-certificate"></div>`;
  } else if (complete && !certificate) {
    html += `
    <div class="courses-item-link" title="Download certificate">
        <a href="${item.pdf}" target="_blank"> 
            <img src="/svg/pdf.svg" alt="Download certificate" class="courses-svg-pdf" />
        </a>
    </div>`;
  } else if (!complete) {
    html += `
    <div class="courses-item-link" title="Certificate not yet obtained">
        <img src="/svg/pdf-gray.svg" alt="Certificate not yet obtained" class="courses-svg-pdf courses-disabled" />
    </div>`;
  }

  html += `</li>`;
  coursesContainer.insertAdjacentHTML("beforeEnd", html);
});
