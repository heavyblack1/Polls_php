-- Create polls DB Note!: must be run as root
CREATE DATABASE polls DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;

-- Create polls user for polls DB
-- Note: To fix docker networking using not localhost "Access denied for user":
-- replace localhost with ip from mysqli error message
CREATE USER polls@localhost IDENTIFIED BY 'root';
GRANT SELECT, INSERT ON polls.questions TO polls@localhost;
GRANT SELECT, INSERT, UPDATE ON polls.answers TO polls@localhost;

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
    CONSTRAINT FK_question FOREIGN KEY (id_question) REFERENCES questions(id_question)
);

-- Just Test Data

INSERT INTO questions(`text`)
	VALUES('What is your favorite operating system for programing?');
INSERT INTO questions(`text`)
	VALUES('What is your favorite programing language?');
INSERT INTO questions(`text`)
	VALUES('Are you using docker as dev enviroment?');

INSERT INTO answers(`text`, votes, id_question)
	VALUES('Linux', 8, 1);
INSERT INTO answers(`text`, votes, id_question)
	VALUES('Python', 7, 2);
INSERT INTO answers(`text`, votes, id_question)
	VALUES('C#', 6, 2);
INSERT INTO answers(`text`, votes, id_question)
	VALUES('Kotlin', 5, 2);
INSERT INTO answers(`text`, votes, id_question)
	VALUES('Yes I do.', 2, 3);

-- If you want clear questions and aswers you created
-- DELETE FROM answers; --answers must be cleared second because foreign key
-- DELETE FROM questions;
-- ALTER TABLE answers AUTO_INCREMENT = 1;
-- ALTER TABLE questions AUTO_INCREMENT = 1;