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
