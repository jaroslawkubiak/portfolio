const techSkillContainer = document.getElementById('techSkillList');
console.log(techSkillContainer);
export const skillsList = [
  {
    skill: 'JavaScript ES6',
    level: 4,
  },
  {
    skill: 'TypeScript',
    level: 2,
  },
  {
    skill: 'Node.JS',
    level: 4,
  },
  {
    skill: 'React & Redux',
    level: 3,
  },
  {
    skill: 'PHP',
    level: 4,
  },
  {
    skill: 'MySQL',
    level: 2,
  },
  {
    skill: 'HTML + CSS',
    level: 4,
  },
  {
    skill: 'Tailwind',
    level: 2,
  },
  {
    skill: 'GIT',
    level: 2,
  },
  {
    skill: 'VS Code',
    level: 3,
  },
];

skillsList.forEach(item => {
  let html = `
    <li class="skills-item-wrapper">
        <div class="skills-item-title">${item.skill}</div>
        <div class="skills-points">`;

  for (let i = 1; i <= 5; i++) {
    html += `<span class="skill-point point-${i} ${item.level >= i ? '' : 'skill-off'}"></span>`;
  }
  html += `</div></li>`;

  techSkillContainer.insertAdjacentHTML('beforeEnd', html);
});
