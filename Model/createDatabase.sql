CREATE TABLE Users (
	uID INT NOT NULL AUTO_INCREMENT,
	username varchar(100) NOT NULL UNIQUE,
	firstName varchar(100),
	lastName varchar(100),
	password varchar(100) NOT NULL,
	facID varchar(20) UNIQUE,
	admin BINARY NOT NULL DEFAULT '0',
	isDeleted BINARY NOT NULL DEFAULT '0',
	PRIMARY KEY (uID)
);

CREATE TABLE BlockedUsers (
	uID INT NOT NULL,
	blockedUID INT NOT NULL,
	PRIMARY KEY (uID,blockedUID)
);

CREATE TABLE Correspondences (
	corrID INT NOT NULL AUTO_INCREMENT,
	title varchar(50) NOT NULL,
	datetimeCreated DATETIME NOT NULL DEFAULT NOW(),
	datetimeLast DATETIME NOT NULL DEFAULT NOW(),
	PRIMARY KEY (corrID)
);

CREATE TABLE CorrUsers (
	corrID INT NOT NULL,
	uID INT NOT NULL,
	isAnonymous BINARY NOT NULL DEFAULT '0',
	PRIMARY KEY (corrID, uID)
);

CREATE TABLE Emails (
	corrID INT NOT NULL,
	emailID INT NOT NULL,
	fromUID INT NOT NULL,
	datetime DATETIME NOT NULL DEFAULT NOW(),
	subject varchar(250) NOT NULL,
	content varchar(8000),
	PRIMARY KEY (corrID, emailID)
);

CREATE TABLE DeletedEmails (
	corrID INT NOT NULL,
	emailID INT NOT NULL,
	uID INT NOT NULL,
	PRIMARY KEY (corrID,emailID,uID)
);

CREATE TABLE ReadEmails (
	corrID INT NOT NULL,
	emailID INT NOT NULL,
	uID INT NOT NULL,
	PRIMARY KEY (corrID,emailID,uID)
);

ALTER TABLE BlockedUsers ADD CONSTRAINT BlockedUsers_fk0 FOREIGN KEY (uID) REFERENCES Users(uID);

ALTER TABLE BlockedUsers ADD CONSTRAINT BlockedUsers_fk1 FOREIGN KEY (blockedUID) REFERENCES Users(uID);

ALTER TABLE CorrUsers ADD CONSTRAINT CorrUsers_fk0 FOREIGN KEY (uID) REFERENCES Users(uID);

ALTER TABLE CorrUsers ADD CONSTRAINT CorrUsers_fk1 FOREIGN KEY (corrID) REFERENCES Correspondences(corrID);

ALTER TABLE Emails ADD CONSTRAINT Emails_fk0 FOREIGN KEY (corrID, fromUID) REFERENCES CorrUsers(corrID, uID);

ALTER TABLE DeletedEmails ADD CONSTRAINT DeletedEmails_fk0 FOREIGN KEY (corrID, emailID) REFERENCES Emails(corrID, emailID);

ALTER TABLE DeletedEmails ADD CONSTRAINT DeletedEmails_fk1 FOREIGN KEY (corrID, uID) REFERENCES CorrUsers(corrID, uID);

ALTER TABLE ReadEmails ADD CONSTRAINT ReadEmails_fk0 FOREIGN KEY (corrID, emailID) REFERENCES Emails(corrID, emailID);

ALTER TABLE ReadEmails ADD CONSTRAINT ReadEmails_fk1 FOREIGN KEY (corrID, uID) REFERENCES CorrUsers(corrID, uID);

DELIMITER $$

CREATE TRIGGER autoincrementEmailID BEFORE INSERT ON Emails
FOR EACH ROW BEGIN
    SET NEW.emailID = (
       SELECT IFNULL(MAX(emailID), 0) + 1
       FROM Emails
       WHERE corrID  = NEW.corrID
    );
END $$

DELIMITER ;
