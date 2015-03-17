CREATE TABLE links (
	id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
	name CHAR(128) NOT NULL,
	uri CHAR(128) NOT NULL,
	status CHAR(128) NOT NULL DEFAULT 'favorite'
);

INSERT INTO links (id, name, uri, status) VALUES (NULL, 'google', 'http://google.com/', 'important');
INSERT INTO links (id, name, uri, status) VALUES (NULL, 'facebook', 'http://facebook.com/', 'favorite');
INSERT INTO links (id, name, uri, status) VALUES (NULL, 'gmail', 'http://gmail.com/', 'favorites');
INSERT INTO links (id, name, uri, status) VALUES (NULL, 'youtube', 'http://youtube.com/', 'favorite');