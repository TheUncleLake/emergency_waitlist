DELETE FROM patients;
DELETE FROM staff;

INSERT INTO staff (staff_name) VALUES ('alexander');
INSERT INTO staff (staff_name) VALUES ('zed');
INSERT INTO staff (staff_name) VALUES ('forward');

INSERT INTO patients (patient_name) VALUES ('james');
INSERT INTO patients (patient_name, staff_id, severity, date_triage)
    VALUES ('tour', 3, 10, '2021-06-15');
INSERT INTO patients (patient_name, staff_id, severity, date_triage)
    VALUES ('hadi', 1, 0, '2023-01-27');
INSERT INTO patients (patient_name, staff_id, severity, date_triage)
    VALUES ('fadi', 2, 4, '2022-09-07');