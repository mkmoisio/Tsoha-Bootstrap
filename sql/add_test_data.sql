INSERT INTO Account(username, password) VALUES ('UsernameHere', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Second User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Third User', 'passwordHere');
INSERT INTO Account(username, password) VALUES ('Neljäs User', 'passwordHere');

INSERT INTO Task(account_id, title, text, date) VALUES ((SELECT id FROM Account LIMIT 1), 'Xplosive', '22:50 sc88: https://vaalikone.yle.fi/kuntavaalit2017/turku/ehdokkaat/13653
22:50 sc88: äänestänkö tätä
22:50 sc88: sil on huge ass mainos mis lukee turku turkulaisille elintasopakolaiset wittuu
22:51 artturi_: yksityisetsivä
22:51 artturi_: :DD
22:51 sc88: Vaalilupaukseni', NOW());
INSERT INTO Task(account_id, title, text, date) VALUES ((SELECT id FROM Account LIMIT 1), 'Turku', '13:25 sc88: eli se juhannuskuva', NOW());

INSERT INTO Classification(title, text) VALUES ('Viikonloppumenot', 'Selite tässä');

INSERT INTO AccountClassification(account_id, classification_id) VALUES ((SELECT id FROM Account LIMIT 1), (SELECT id FROM Classification LIMIT 1));
INSERT INTO TaskClassification(task_id, classification_id) VALUES ((SELECT id FROM Task LIMIT 1), (SELECT id FROM Classification LIMIT 1));

