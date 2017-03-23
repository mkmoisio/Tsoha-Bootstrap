INSERT INTO Account(username, password) VALUES ('UsernameHere', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Second User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Third User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Neljäs User', 'passwordHere');

INSERT INTO Task(account_id, title, text, due) VALUES ((SELECT id FROM Account LIMIT 1), 'Otsikko tässä', 'Selitekenttä tässä', NOW());
INSERT INTO Task(account_id, title, text, due) VALUES ((SELECT id FROM Account LIMIT 1), '2 Otsikko2 tässä', 'Toinen task ekalle userille', NOW());

INSERT INTO Classification(title, text) VALUES ('Viikonloppumenot', 'Selite tässä');

INSERT INTO AccountClassification(account_id, classification_id) VALUES ((SELECT id FROM Account LIMIT 1), (SELECT id FROM Classification LIMIT 1));
INSERT INTO TaskClassification(task_id, classification_id) VALUES ((SELECT id FROM Task LIMIT 1), (SELECT id FROM Classification LIMIT 1));

