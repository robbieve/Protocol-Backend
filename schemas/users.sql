CREATE TABLE users (
  "id" INT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 1013 INCREMENT BY 97),
  "name" VARCHAR(100),
  "email" VARCHAR(100) NOT NULL,
  "password" VARCHAR(100) NOT NULL,
  "source" VARCHAR(50) NOT NULL,
  "created" INT NOT NULL,
  "last_login" INT,
  "status" SMALLINT DEFAULT 0
);