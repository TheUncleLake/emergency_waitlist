<?php
namespace EmergencyWaitlist;

class ConnectionDB {
    private static function connectDb() {
        // Set up the database connection as you like
        $dbconn = pg_connect("user=postgres dbname=emergency_waitlist");
        return $dbconn;
    }

    static function queryDb($query) {
        $dbconn = static::connectDb();
        if (!$dbconn) return "Failed to connect to database";
        $result = pg_query($dbconn, $query);
        if (!$result) return "Failed to query database";
        $data = pg_fetch_all($result);
        pg_close($dbconn);
        return $data;
    }
}