const articleTab = getID('articlesTab'),
  projectTab = getID('projectsTab'),
  articles = getID('recentArticles'),
  projects = getID('recentProjects');

function displayProjects() {
  projects.classList.remove('hidden');
  articles.classList.add('hidden');
}

function displayArticles() {
  articles.classList.remove('hidden');
  projects.classList.add('hidden');
}

articleTab.addEventListener('click', displayArticles);
projectTab.addEventListener('click', displayProjects);
