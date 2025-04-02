const techSkillContainer = document.getElementById("techSkillList");

export const skillsList = [
  {
    skill: "JavaScript ES6",
    level: 4,
  },
  {
    skill: "TypeScript",
    level: 4,
  },
  {
    skill: "Node.JS/Nest.JS",
    level: 3,
  },
  {
    skill: "Nest.JS",
    level: 3,
  },
  {
    skill: "Angular",
    level: 3,
  },
  {
    skill: "RxJS",
    level: 2,
  },
  {
    skill: "React & Redux",
    level: 2,
  },
  {
    skill: "PHP",
    level: 4,
  },
  {
    skill: "MySQL",
    level: 3,
  },
  {
    skill: "Redis",
    level: 2,
  },
  {
    skill: "HTML + CSS",
    level: 4,
  },
  {
    skill: "WordPress & Elementor",
    level: 3,
  },
  {
    skill: "Tailwind",
    level: 2,
  },
  {
    skill: "GIT",
    level: 3,
  },
  {
    skill: "VS Code",
    level: 4,
  },
];

skillsList.forEach((item) => {
  let html = `
    <li class="skills-item-wrapper">
        <div class="skills-item-title">${item.skill}</div>
        <div class="skills-points">`;

  for (let i = 1; i <= 5; i++) {
    html += `<span class="skill-point point-${i} ${
      item.level >= i ? "" : "skill-off"
    }"></span>`;
  }
  html += `</div></li>`;

  techSkillContainer.insertAdjacentHTML("beforeEnd", html);
});
