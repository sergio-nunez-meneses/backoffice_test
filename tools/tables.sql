-- tables
CREATE TABLE authors(
  author_id INT AUTO_INCREMENT NOT NULL,
  author_status VARCHAR (50) NOT NULL,
  author_username VARCHAR (50) NOT NULL,
  author_password VARCHAR (250) NOT NULL,
  PRIMARY KEY (author_id)
)charset=utf8;

CREATE TABLE projects(
  project_id INT AUTO_INCREMENT NOT NULL,
	project_title VARCHAR(50) NOT NULL,
  project_text TEXT NOT NULL,
	DATETIME DATETIME NOT NULL,
  project_technologies VARCHAR(250) NOT NULL,
  project_image VARCHAR (250) NOT NULL,
  author_id INT NOT NULL,
	PRIMARY KEY(project_id),
  FOREIGN KEY (author_id) REFERENCES authors(author_id)
)charset=utf8;

CREATE TABLE articles(
  article_id INT AUTO_INCREMENT NOT NULL,
  article_title VARCHAR (150) NOT NULL,
  article_text TEXT NOT NULL,
  DATETIME DATETIME NOT NULL,
  article_image VARCHAR (250) NOT NULL,
  author_id INT NOT NULL,
  PRIMARY KEY (article_id),
  FOREIGN KEY (author_id) REFERENCES authors(author_id)
)charset=utf8;

CREATE TABLE archives(
  archive_id INT AUTO_INCREMENT NOT NULL,
  archive_title VARCHAR (150) NOT NULL,
  archive_text TEXT NOT NULL,
  DATETIME DATETIME NOT NULL,
  archive_image VARCHAR (250) NOT NULL,
  aricle_id INT NOT NULL,
  PRIMARY KEY (archive_id),
  FOREIGN KEY (article_id) REFERENCES articles(article_id)
)charset=utf8;

CREATE TABLE project_categories(
  category_id INT AUTO_INCREMENT NOT NULL,
  category_name VARCHAR(250) NOT NULL,
  project_id INT NOT NULL,
  PRIMARY KEY (category_id),
  FOREIGN KEY (project_id) REFERENCES projects(project_id)
)charset=utf8;

CREATE TABLE article_categories(
  category_id INT AUTO_INCREMENT NOT NULL,
  category_name VARCHAR(250) NOT NULL,
  article_id INT NOT NULL,
  PRIMARY KEY (category_id),
  FOREIGN KEY (article_id) REFERENCES articles(article_id)
)charset=utf8;
