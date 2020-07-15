// VARIABLES
const signInTab = getID('sign-in-tab'),
  signUpTab = getID('sign-up-tab'),
  signInForm = getID('sign-in-form'),
  signUpForm = getID('sign-up-form');

// FUNCTIONS
function displaySignIn() {
  // signInTab.classList.remove('inactive');
  // signUpTab.classList.add('inactive');
  signInForm.classList.remove('hidden');
  signUpForm.classList.add('hidden');
}

function displaySignUp() {
  // signUpTab.classList.remove('inactive');
  // signInTab.classList.add('inactive');
  signUpForm.classList.remove('hidden');
  signInForm.classList.add('hidden');
}

// EVENT LISTENERS
signInTab.addEventListener('click', displaySignIn);
signUpTab.addEventListener('click', displaySignUp);
