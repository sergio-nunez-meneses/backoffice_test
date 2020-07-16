const signTab = getID('sign-in-tab'),
  signInForm = getID('sign-in-form'),
  signUpForm = getID('sign-up-form');

function displaySignForm() {
  if (signUpForm.classList.contains('hidden')) {
    signUpForm.classList.remove('hidden');
    signInForm.classList.add('hidden');
    signTab.innerHTML = 'sign up';
  } else {
    signInForm.classList.remove('hidden');
    signUpForm.classList.add('hidden');
    signTab.innerHTML = 'sign in';
  }
}

signTab.addEventListener('click', displaySignForm);
