INSERT INTO Account(username, password) VALUES ('UsernameHere', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Second User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Third User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Neljäs User', 'passwordHere');

INSERT INTO Task(account_id, title, text, date) VALUES ((SELECT id FROM Account LIMIT 1), 'Xplosive', 'Aukeaa ysilt', NOW());
INSERT INTO Task(account_id, title, text, date) VALUES ((SELECT id FROM Account LIMIT 1), 'Skön', 'www.skone.fi', NOW());

INSERT INTO Classification(title, text) VALUES ('Viikonloppumenot', 'Selite tässä');

INSERT INTO AccountClassification(account_id, classification_id) VALUES ((SELECT id FROM Account LIMIT 1), (SELECT id FROM Classification LIMIT 1));
INSERT INTO TaskClassification(task_id, classification_id) VALUES ((SELECT id FROM Task LIMIT 1), (SELECT id FROM Classification LIMIT 1));

