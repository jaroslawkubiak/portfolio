'use strict';

//game
let highScore = 0;
const highest = 100;
document.querySelector('.score').textContent = `💯 Twój wynik: ${highest}`;

//losowanie liczby z zakresu od 1 do zmiennej highest
let secretNumber = Math.trunc(Math.random() * highest) + 1;
let score = highest;

const rules = `(od 1 do  ${highest})`;
document.querySelector('#maxNumber').textContent = rules;

//funkcja wyswietlajaca komunikaty dla usera
const displayMessage = function (message) {
  document.querySelector('.message').textContent = message;
};

function checkInput() {
  const inputValue = Number(document.querySelector('.guess').value);

  if (inputValue !== 0 && inputValue <= highest)
    document.querySelector('.guess').value = inputValue;
  else document.querySelector('.guess').value = '';
}

document.querySelector('.check').addEventListener('click', function () {
  const guess = Number(document.querySelector('.guess').value);
  const scoreDecrese = document.getElementById('scoreDecrese');

  //gdy nie wprowadzono poprawnych danych - brak input.
  if (!guess) {
    displayMessage('Brak numeru!');

    //gdy wprowadzony numer jest spoza zakresu
    //gdy wygralismy
  } else if (guess <= 0 || guess > highest) {
    displayMessage('Podany numer jest poza wymaganym zakresem!');
  } else if (guess === secretNumber) {
    document.querySelector('.number').textContent = secretNumber;
    displayMessage('👍 Poprawny numer');

    //zmiana koloru tła
    document.querySelector('body').style.backgroundColor = '#60b347';

    //zmiana rozmiaru width
    document.querySelector('.number').style.width = '200px';

    //zmiana koloru czcionki
    document.querySelector('.message').style.color = '#000000';

    //sprawdzamy highscore
    if (score > highScore) {
      highScore = score;
      document.querySelector('.highscore').textContent = highScore;
    }

    //gdy guess is wrong
  } else if (guess !== secretNumber) {
    if (score > 1) {
      displayMessage(guess > secretNumber ? '🔺 Za wysoki' : '🔻 Za niski');
      score--;
      document.querySelector('.score').textContent = `💯 Twój wynik: ${score}`;

      scoreDecrese.classList.add('animate');
      scoreDecrese.textContent = '-1';
      setTimeout(()=>{
        scoreDecrese.classList.remove('animate');
        scoreDecrese.textContent = '';
      }, 1000);
    
    } else {
      displayMessage('☹ Koniec gry');
    }
  }
});

document.querySelector('.again').addEventListener('click', function () {
  secretNumber = Math.trunc(Math.random() * highest) + 1;
  score = highest;
  //reset
  document.querySelector('body').style.backgroundColor = '#222';
  document.querySelector('.number').style.width = '50px';

  document.querySelector('.number').textContent = '?';

  document.querySelector('.guess').value = '';

  document.querySelector('.message').style.color = '#0bb2f9';

  displayMessage('Zacznij zgadywać ...');

  document.querySelector('.score').textContent = `💯 Twój wynik: ${score}`;
});
