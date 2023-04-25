DROP DATABASE IF EXISTS Guessite;

CREATE DATABASE IF NOT EXISTS Guessite DEFAULT CHARACTER SET = utf8;

USE Guessite;


CREATE TABLE accountStats
(
    username VARCHAR(20) PRIMARY KEY,
    score INT NOT NULL DEFAULT 0,
    tries   INT NOT NULL DEFAULT 0,
    guessed INT NOT NULL DEFAULT 0
) ENGINE = InnoDB;

CREATE TABLE account
(
    username VARCHAR(20) PRIMARY KEY,
    pw       VARCHAR(40) NOT NULL,
    email    VARCHAR(30) NOT NULL,
    stats    VARCHAR(20) NOT NULL,
    FOREIGN KEY (stats) REFERENCES accountStats (username)
        ON DELETE CASCADE
        ON UPDATE CASCADE

) ENGINE = InnoDB;


CREATE TABLE club
(
    name VARCHAR(20) PRIMARY KEY,
    level INT NOT NULL DEFAULT 1
) ENGINE = InnoDB;


ALTER TABLE account
    ADD COLUMN club VARCHAR(20);

ALTER TABLE club
    ADD COLUMN owner VARCHAR(20) NOT NULL;

ALTER TABLE account
    ADD FOREIGN KEY (club) REFERENCES club (name);

ALTER TABLE club
    ADD FOREIGN KEY (owner) REFERENCES account (username);

CREATE TABLE imageStats
(
    statsID INT NOT NULL AUTO_INCREMENT,
    tries   INT NOT NULL DEFAULT 0,
    guessed INT NOT NULL DEFAULT 0,
    PRIMARY KEY (statsID)
) ENGINE = INNODB;

CREATE TABLE image
(
    imageID INT  NOT NULL AUTO_INCREMENT,
    image   BLOB NOT NULL,
    PRIMARY KEY (imageID)
) ENGINE = InnoDB;

CREATE TABLE guess
(
    userID  INT NOT NULL,
    imageID INT NOT NULL,
    PRIMARY KEY (userID, imageID)
) ENGINE = InnoDB;

INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Mario', 30, 20, 13);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Luca', 55, 25, 18);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Giulia', 24, 15, 8);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Francesco', 20, 10, 5);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Simone', 32, 20, 12);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Elisa', 40, 30, 15);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Giovanni', 39, 17, 8);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Sara', 26, 11, 5);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Davide', 34, 14, 7);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('admin', 0, 0, 0);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Alessandro', 23, 9, 4);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Chiara', 48, 19, 9);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Lorenzo', 29, 13, 6);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Valentina', 51, 21, 10);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Gabriele', 22, 8, 3);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Elena', 45, 17, 8);
INSERT INTO accountStats (username, score, tries, guessed)
VALUES ('Riccardo', 33, 12, 6);

INSERT INTO account (username, email, pw, stats, club)
VALUES ('Mario', 'mario@gmail.com', MD5('pwpwpw'), 'Mario', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Francesco', 'francesco@example.com', MD5('securepw123'), 'Francesco', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Lorenzo', 'lorenzo@example.com', MD5('securepw123'), 'Lorenzo', NULL);

INSERT INTO club (name, owner, level)
VALUES ('GuessiteOfficial', 'Mario', 1);
INSERT INTO club (name, owner, level)
VALUES ('Informatik', 'Lorenzo', 1);
INSERT INTO club (name, owner, level)
VALUES ('Watermelon', 'Francesco', 1);

UPDATE account
SET club = 'GuessiteOfficial'
WHERE username = 'Mario';
UPDATE account
SET club = 'Informatik'
WHERE username = 'Lorenzo';
UPDATE account
SET club = 'Watermelon'
WHERE username = 'Francesco';


INSERT INTO account (username, email, pw, stats, club)
VALUES ('Luca', 'luca@example.com', MD5('password123'), 'Luca', 'GuessiteOfficial');
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Giulia', 'giulia@example.com', MD5('myp@ssword'), 'Giulia', 'GuessiteOfficial');
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Simone', 'simone@example.com', MD5('strongpw123'), 'Simone', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Elisa', 'elisa@example.com', MD5('mypassword'), 'Elisa', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Giovanni', 'giovanni@example.com', MD5('myp@ssword123'), 'Giovanni', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('admin', 'admin@admin.com', MD5('admin'), 'admin', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Sara', 'sara@example.com', MD5('securepw456'), 'Sara', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Davide', 'davide@example.com', MD5('strongpw789'), 'Davide', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Alessandro', 'alessandro@example.com', MD5('mypassword321'), 'Alessandro', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Chiara', 'chiara@example.com', MD5('myp@ssword'), 'Chiara', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Valentina', 'valentina@example.com', MD5('strongpw987'), 'Valentina', 'Informatik');
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Gabriele', 'gabriele@example.com', MD5('myp@ssword789'), 'Gabriele', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Elena', 'elena@example.com', MD5('mypassword123'), 'Elena', NULL);
INSERT INTO account (username, email, pw, stats, club)
VALUES ('Riccardo', 'riccardo@example.com', MD5('securepw456'), 'Riccardo', NULL);

