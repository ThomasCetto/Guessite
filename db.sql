DROP DATABASE IF EXISTS Guessite;

CREATE DATABASE IF NOT EXISTS Guessite DEFAULT CHARACTER SET = utf8;

USE Guessite;

CREATE TABLE accountStats
(
    statsID INT NOT NULL AUTO_INCREMENT,
    tries   INT NOT NULL DEFAULT 0,
    guessed INT NOT NULL DEFAULT 0,
    PRIMARY KEY (statsID)
) ENGINE = INNODB;

CREATE TABLE account
(
    userID   INT         NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    pw       VARCHAR(20) NOT NULL,
    email    VARCHAR(30) NOT NULL UNIQUE,
    stats    INT         NOT NULL,
    PRIMARY KEY (userID),
    FOREIGN KEY (stats) REFERENCES accountStats (statsID)
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

