INSERT INTO Users(username, password, admin) VALUES('admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1);
INSERT INTO Users(username, password) VALUES('Pesho', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');
INSERT INTO Users(username, password) VALUES('Gosho', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');
INSERT INTO Users(username, password) VALUES('Losho', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4');

INSERT INTO Correspondences(title) VALUES('firstCorr');
INSERT INTO Correspondences(title) VALUES('normal');
INSERT INTO Correspondences(title) VALUES('losha');
INSERT INTO Correspondences(title) VALUES('оценка');

INSERT INTO CorrUsers(corrID, uID) VALUES(1, 1);
INSERT INTO CorrUsers(corrID, uID) VALUES(1, 4);
INSERT INTO CorrUsers(corrID, uID) VALUES(2, 2);
INSERT INTO CorrUsers(corrID, uID) VALUES(2, 3);
INSERT INTO CorrUsers(corrID, uID) VALUES(2, 4);
INSERT INTO CorrUsers(corrID, uID) VALUES(3, 4);
INSERT INTO CorrUsers(corrID, uID) VALUES(3, 3);
INSERT INTO CorrUsers(corrID, uID, isAnonymous) VALUES(4, 2, 1);
INSERT INTO CorrUsers(corrID, uID, isAnonymous) VALUES(4, 3, 1);

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(1, 1, 'test correspondence', 'Hello! That is a test for the new system');

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(1, 4, 'Congratulations', 'Hi! The new system works very well');

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(2, 3, 'Hello everybody', 'Hey all! Jivi i zdravi');

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(3, 4, 'Zashto pishesh na vsichki be bunak', 'Shte te susipq');

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(1, 1, 'Разочераван съм, Лошо', 'Лошо ще те блокирам');

UPDATE Users SET isDeleted=1 WHERE uID=4;

INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(4, 2, 'Браво!', 'Рефератът ти е чук. Давам ти 3/10, защото ме прецака на дискретните (Знам, че си ти Лошо)');
INSERT INTO Emails(corrID, fromUID, subject, content) 
    VALUES(4, 3, 'Бъркаш се', 'Аз не съм лошо. Ама оценката ме устройва');
