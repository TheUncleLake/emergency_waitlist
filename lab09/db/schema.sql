DROP TABLE IF EXISTS patients, staff;

CREATE TABLE staff(
    staff_id SERIAL PRIMARY KEY,
    staff_name VARCHAR(20)
);

CREATE TABLE patients(
    patient_id SERIAL PRIMARY KEY,
    patient_name VARCHAR(20),
    staff_id INTEGER REFERENCES staff(staff_id),
    severity INTEGER,
    date_triage DATE
);