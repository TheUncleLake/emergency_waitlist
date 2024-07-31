# Emergency Waitlist

## Overview

The Hospital Triage application helps staff and patients better understand wait times while in the emergency room. The application will be administered by the triage staff based on two dimensions: severity of injuries and the length of time already in the queue. Administrators will see the full list of patients, but users can sign-in with their name and 3-letter code showing an approximate wait time, which is updated as patients are treated.

## Resources

* [Database Design](docs/db.md)
* [Database Schema](db/schema.sql)
* [Sample Data (SQL)](db/seed.sql)

## Setup

This application requires PHP 8.1+ and PostgreSQL 14+. The following installations may help.

```bash
sudo apt install php
sudo apt install php-pgsql
sudo apt install postgresql
sudo apt install postgresql-client
```

### PostgreSQL 14+

To set up the database locally, first log in as `postgres`, i.e. `sudo -u postgres -i`, if not already.

We now create the database `emergency_waitlist` needed for the application, if not already.

```bash
psql -c "create database emergency_waitlist"
```

Load the schema required for the application by running these commands from the root of the project.

```bash
psql -d emergency_waitlist -f ./db/schema.sql
psql -d emergency_waitlist -f ./db/seed.sql
```

We can test the database by querying it.

```bash
psql -c "select * from patients"
```

The output should be similar to the following.

```
 patient_id | patient_name | staff_id | severity | date_triage 
------------+--------------+----------+----------+-------------
          1 | james        |          |          |
          2 | tour         |        3 |       10 | 2021-06-15
          3 | hadi         |        1 |        0 | 2023-01-27
          4 | fadi         |        2 |        4 | 2022-09-07
(4 rows)
```

### PHP 8.1+

To start the PHP server locally, run the following commands from the root of the project.

```bash
(cd public && php -S localhost:4000)
```

Note: It might be better to do that while still logged in as `postgres` or there is a risk of authentication failure in the database connection. You may change the setup of the database connection from the `pg_connect()` method in `app/models/ConnectionDB.php` as desired.

The server is hosted in http://localhost:4000/.