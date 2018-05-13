CREATE TABLE elements (
  "id" INT PRIMARY KEY GENERATED BY DEFAULT AS IDENTITY (START WITH 1013 INCREMENT BY 97),
  "type" SMALLINT NOT NULL,
  "url" VARCHAR(2083) NOT NULL,
  "start_locator" VARCHAR(200) NOT NULL,
  "start_offset" INT NOT NULL,
  "end_locator" VARCHAR(200) NOT NULL,
  "end_offset" INT NOT NULL,
  "image" VARCHAR(200),
  "text" TEXT,
  "rect" VARCHAR(100),
  "created" INT NOT NULL,
  "created_by" INT NOT NULL,
  "updated" INT NOT NULL,
  "updated_by" INT NOT NULL,
  "status" SMALLINT DEFAULT 0
);

CREATE INDEX elements_url_idx on elements ("url");
