<?php
namespace EmergencyWaitlist;

class User {
    static $adminUsername = "admin";
    static $adminPassword = "password";

    static function isPatient() {
        return isset($_SESSION['uname']) && !isset($_SESSION['pass']);
    }

    static function isAdmin() {
        return isset($_SESSION['uname']) && $_SESSION['uname'] == static::$adminUsername &&
            isset($_SESSION['pass']) && $_SESSION['pass'] == static::$adminPassword;
    }
}