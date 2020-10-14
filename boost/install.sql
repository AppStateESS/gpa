BEGIN;

CREATE TABLE report_data {
    id SERIAL,
    name CHARACTER VARYING,
    user CHARACTER VARYING,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    term CHARACTER VARYING,
    PRIMARY KEY (id)
};

CREATE TABLE report_results {
    id SERIAL,
    first_name CHARACTER VARYING,
    last_name CHARACTER VARYING,
    banner CHARACTER VARYING,
    transfer BOOLEAN DEFAULT 0,
    credits INT(3),
    year CHARACTER VARYING,
    gpa CHARACTER VARYING,
    hs_gpa CHARACTER VARYING,
    term CHARACTER VARYING,
    report_id INTEGER REFERENCES report_data(id),
    PRIMARY KEY (id)
};

COMMIT;
