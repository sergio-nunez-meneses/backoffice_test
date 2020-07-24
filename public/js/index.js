const ELEMENTS_TAB = getID('articlesTab'),
  ALL_ELEMENTS_TAB = getID('allArticlesTab'),
  ARTICLES = getID('recentArticles'),
  PROJECTS = getID('recentProjects'),
  ALL_ARTICLES = getID('allArticles'),
  ALL_PROJECTS = getID('allProjects');

function displayElements() {
  if (PROJECTS.classList.contains('hidden')) {
    PROJECTS.classList.remove('hidden');
    ARTICLES.classList.add('hidden');
    ALL_ARTICLES.classList.add('hidden');
    ALL_PROJECTS.classList.add('hidden');
    ELEMENTS_TAB.innerHTML = 'show articles';
  } else {
    ARTICLES.classList.remove('hidden');
    PROJECTS.classList.add('hidden');
    ALL_ARTICLES.classList.add('hidden');
    ALL_PROJECTS.classList.add('hidden');
    ELEMENTS_TAB.innerHTML = 'show projects';
  }
}

function displayAll() {
  if (ALL_ARTICLES.classList.contains('hidden')) {
    ALL_ARTICLES.classList.remove('hidden');
    ALL_PROJECTS.classList.add('hidden');
    ARTICLES.classList.add('hidden');
    PROJECTS.classList.add('hidden');
    ALL_ELEMENTS_TAB.innerHTML = 'show all articles';
  } else {
    ALL_PROJECTS.classList.remove('hidden');
    ALL_ARTICLES.classList.add('hidden');
    ARTICLES.classList.add('hidden');
    PROJECTS.classList.add('hidden');
    ALL_ELEMENTS_TAB.innerHTML = 'show all projects';
  }
}

ELEMENTS_TAB.addEventListener('click', displayElements);
ALL_ELEMENTS_TAB.addEventListener('click', displayAll);
