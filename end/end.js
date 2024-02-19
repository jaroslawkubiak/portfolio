// const containerDoKonca = document.getElementById('do-konca');
const containerDni = document.getElementById('dni');
const containerGodzin = document.getElementById('godzin');
const containerMinut = document.getElementById('minut');
const containerSekund = document.getElementById('sekund');
const urlop = 7;
// const doKoncaStycznia = 22 + 21 + 23;
const ileSwiat = 2;
const CONUT_INTERVAL = 60;

const startDate = new Date();
const endDate = new Date('1/31/2024');

// console.log('startDate=', startDate);
// console.log('endDate=', endDate);

function getBusinessDatesCount(start, end) {
  let count = 0;
  // console.log('############\n start=', start, 'end=', end);
  while (start <= end) {
    start.setDate(start.getDate() +1);
    const dayOfWeek = start.getDay();
    if (dayOfWeek !== 0 && dayOfWeek !== 6) count++;
  }
  return count+1;
}

const numOfDates = getBusinessDatesCount(startDate, endDate);
// console.log('numOfDates=', numOfDates);

function countDown(days, hours, minutes, seconds) {
  containerDni.innerHTML = days;
  containerGodzin.innerHTML = hours;
  containerMinut.innerHTML = minutes;
  containerSekund.innerHTML = seconds;
}



// counting how many days
let ileDni = numOfDates - urlop - ileSwiat;
let ileGodzin = ileDni * 8;
let ileMinut = ileDni * 8 * 60;
let ileSekund = ileDni * 8 * 60 * 60;

//initial display
countDown(ileDni, ileGodzin, ileMinut, ileSekund);

let countSec = 0;
let countMin = 0;
let countHour = 0;

setInterval(() => {
  countSec++;
  if (countSec % CONUT_INTERVAL === 0) {
    countMin++;
    if (countMin % CONUT_INTERVAL === 0) countHour++;
  }

  countDown(ileDni, ileGodzin - countHour, ileMinut - countMin, ileSekund - countSec);
}, 1000);
