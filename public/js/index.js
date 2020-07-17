const ELEMENTS_TAB = getID('articlesTab'),
  ARTICLES = getID('recentArticles'),
  PROJECTS = getID('recentProjects');

function displayElements() {
  if (PROJECTS.classList.contains('hidden')) {
    PROJECTS.classList.remove('hidden');
    ARTICLES.classList.add('hidden');
    ELEMENTS_TAB.innerHTML = 'show articles';
  } else {
    ARTICLES.classList.remove('hidden');
    PROJECTS.classList.add('hidden');
    ELEMENTS_TAB.innerHTML = 'show projects';
  }
}

ELEMENTS_TAB.addEventListener('click', displayElements);
