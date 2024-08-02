<?php
namespace EmergencyWaitlist;

class User {
    static function isLoggedIn() {
        return isset($_SESSION['uname']) && isset($_SESSION['code']);
    }

    static function isAdmin() {
        return static::isLoggedIn() && $_SESSION['uname'] == "admin" && $_SESSION['code'] == "password";
    }
}