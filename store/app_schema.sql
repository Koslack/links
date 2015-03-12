CREATE TABLE links (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	url CHAR(128) NOT NULL,
	status CHAR(128) NOT NULL DEFAULT 'favorite'
);

INSERT INTO links
	(id, url, status)
VALUES
	(NULL, 'http://google.com/', 'important'),
	(NULL, 'http://facebook.com/', 'favorites'),
	(NULL, 'http://gmail.com/', 'favorites'),
	(NULL, 'http://youtube.com/', 'favorites');
