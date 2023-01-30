-- Create polls DB Note!: must be run as root
CREATE DATABASE polls DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
-- Create polls user for polls DB
CREATE USER polls@localhost IDENTIFIED BY 'root';
GRANT SELECT, INSERT, DELETE ON polls.* TO polls@localhost;
GRANT SELECT, INSERT, UPDATE, DELETE ON polls.answers TO polls@localhost;

-- fix docker problem replace localhost with your local ip
GRANT ALL PRIVILEGES ON *.* TO polls@localhost WITH GRANT OPTION;

-- All commands will be applied on eshop db
use polls;
 
CREATE TABLE questions(
	id_question INTEGER NOT NULL auto_increment,
	text VARCHAR(1000) NOT NULL,
	PRIMARY KEY (id_question)
);

CREATE TABLE  answers(
	id_answer INTEGER NOT NULL auto_increment,
	text varchar(100) NOT NULL,
	votes int NOT NULL ,
    id_question int NOT NULL,
	PRIMARY KEY (id_answer),
    CONSTRAINT FK_comodity FOREIGN KEY (id_question) REFERENCES commodity(id_question)
);

-- Just Test Data
INSERT INTO polls.questions
(`text`)
VALUES('Are you using docker as dev enviroment?');


INSERT INTO polls.answers
(`text`, votes, id_question)
VALUES('Yes', 2, 1);
