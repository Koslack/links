CREATE TABLE links (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	name CHAR(128) NOT NULL,
	url CHAR(128) NOT NULL,
	status CHAR(128) NOT NULL DEFAULT 'favorite'
);

INSERT INTO links
	(id, name, url, status)
VALUES
	(NULL, 'google', 'http://google.com/', 'important'),
	(NULL, 'facebook', 'http://facebook.com/', 'favorites'),
	(NULL, 'gmail', 'http://gmail.com/', 'favorites'),
	(NULL, 'youtube', 'http://youtube.com/', 'favorites');
