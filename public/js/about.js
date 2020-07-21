const CV_TAB = getID('cvTab'),
  CLOSE_BTN = getID('closeBtn'),
  MODAL = getID('myModal');

function displayCV() {
  if (MODAL.classList.contains('hidden')) {
    MODAL.classList.remove('hidden');
  } else {
    MODAL.classList.add('hidden');
  }
}

CV_TAB.addEventListener('click', displayCV);
CLOSE_BTN.addEventListener('click', displayCV);
