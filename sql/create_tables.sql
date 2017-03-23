CREATE TABLE Account (
    id SERIAL PRIMARY KEY,
    username varchar(20) NOT NULL UNIQUE,
    password varchar(20) NOT NULL  
);

CREATE TABLE Task (
    id SERIAL PRIMARY KEY,
    account_id INTEGER REFERENCES Account(id),
    title varchar(40) NOT NULL,
    text varchar(200),
    due DATE  
);

CREATE TABLE Classification (
    id SERIAL PRIMARY KEY,
    title varchar(20) NOT NULL,
    text varchar(300) NOT NULL
);


CREATE TABLE TaskClassification (
    id SERIAL PRIMARY KEY,
    task_id INTEGER REFERENCES Task(id),
    classification_id INTEGER REFERENCES Classification(id)
);

CREATE TABLE AccountClassification(
    id SERIAL PRIMARY KEY, 
    account_id INTEGER REFERENCES Account(id),
    classification_id INTEGER REFERENCES Classification(id)
);