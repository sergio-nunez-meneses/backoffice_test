const SIGN_TAB = getID('sign-in-tab'),
  SIGN_IN_FORM = getID('sign-in-form'),
  SIGN_UP_FORM = getID('sign-up-form');

function displaySignForm() {
  if (SIGN_UP_FORM.classList.contains('hidden')) {
    SIGN_UP_FORM.classList.remove('hidden');
    SIGN_IN_FORM.classList.add('hidden');
    SIGN_TAB.innerHTML = 'sign in';
  } else {
    SIGN_IN_FORM.classList.remove('hidden');
    SIGN_UP_FORM.classList.add('hidden');
    SIGN_TAB.innerHTML = 'sign up';
  }
}

SIGN_TAB.addEventListener('click', displaySignForm);
