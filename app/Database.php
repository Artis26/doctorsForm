<?php

namespace App;

use PDO;
use PDOException;

class  Database extends PDO{
    private static $connection = null;

    public static function connection() {

        if (self::$connection === null) {
            try {
                $username = "admin";
                $password = "admin";

                self::$connection = new PDO('mysql:host=localhost;dbname=doctor', $username, $password);

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die;
            }
        }
        return self::$connection;
    }
}