DROP TABLE IF EXISTS post;
CREATE TABLE post (
  id      INT UNSIGNED  NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
  url     CHAR(100)     NOT NULL  UNIQUE,
  titulo  CHAR(100)     NOT NULL  UNIQUE,
  data    DATETIME      NOT NULL,
  texto   TEXT          NOT NULL
);


DROP TABLE IF EXISTS comment;
CREATE TABLE comment (
  id        INT UNSIGNED    NOT NULL  AUTO_INCREMENT  PRIMARY KEY,
  post_id   INT UNSIGNED    NOT NULL,
  ip        CHAR(15)        NOT NULL,
  data      DATETIME        NOT NULL,
  aprovado  ENUM('0', '1')  NOT NULL  DEFAULT '0',
  nome      CHAR(30)        NOT NULL,
  texto     TEXT            NOT NULL
);