DROP DATABASE IF EXISTS Guessite;

CREATE DATABASE IF NOT EXISTS Guessite DEFAULT CHARACTER SET = utf8;

USE Guessite;

CREATE TABLE accountStats
(
    username VARCHAR(20) PRIMARY KEY,
    score INT NOT NULL DEFAULT 0,
    tries   INT NOT NULL DEFAULT 0,
    guessed INT NOT NULL DEFAULT 0
) ENGINE = INNODB;

CREATE TABLE account
(
    username VARCHAR(20) PRIMARY KEY,
    pw       VARCHAR(20) NOT NULL,
    email    VARCHAR(30) NOT NULL,
    stats    VARCHAR(20) NOT NULL,

    FOREIGN KEY (username) REFERENCES accountStats (username)
        ON DELETE CASCADE
) ENGINE = InnoDB;

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



INSERT INTO account (username, email, pw, stats)
VALUES ('Mario', 'mario@gmail.com', MD5('pwpwpw'), 'Mario');
INSERT INTO account (username, email, pw, stats)
VALUES ('Luca', 'luca@example.com', MD5('password123'), 'Luca');
INSERT INTO account (username, email, pw, stats)
VALUES ('Giulia', 'giulia@example.com', MD5('myp@ssword'), 'Giulia');
INSERT INTO account (username, email, pw, stats)
VALUES ('Francesco', 'francesco@example.com', MD5('securepw123'), 'Francesco');
INSERT INTO account (username, email, pw, stats)
VALUES ('Simone', 'simone@example.com', MD5('strongpw123'), 'Simone');
INSERT INTO account (username, email, pw, stats)
VALUES ('Elisa', 'elisa@example.com', MD5('mypassword'), 'Elisa');
INSERT INTO account (username, email, pw, stats)
VALUES ('Giovanni', 'giovanni@example.com', MD5('myp@ssword123'), 'Giovanni');
INSERT INTO account (username, email, pw, stats)
VALUES ('Sara', 'sara@example.com', MD5('securepw456'), 'Sara');
INSERT INTO account (username, email, pw, stats)
VALUES ('Davide', 'davide@example.com', MD5('strongpw789'), 'Davide');
INSERT INTO account (username, email, pw, stats)
VALUES ('Alessandro', 'alessandro@example.com', MD5('mypassword321'), 'Alessandro');
INSERT INTO account (username, email, pw, stats)
VALUES ('Chiara', 'chiara@example.com', MD5('myp@ssword'), 'Chiara');
INSERT INTO account (username, email, pw, stats)
VALUES ('Lorenzo', 'lorenzo@example.com', MD5('securepw123'), 'Lorenzo');
INSERT INTO account (username, email, pw, stats)
VALUES ('Valentina', 'valentina@example.com', MD5('strongpw987'), 'Valentina');
INSERT INTO account (username, email, pw, stats)
VALUES ('Gabriele', 'gabriele@example.com', MD5('myp@ssword789'), 'Gabriele');
INSERT INTO account (username, email, pw, stats)
VALUES ('Elena', 'elena@example.com', MD5('mypassword123'), 'Elena');
INSERT INTO account (username, email, pw, stats)
VALUES ('Riccardo', 'riccardo@example.com', MD5('securepw456'), 'Riccardo');

