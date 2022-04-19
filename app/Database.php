<?php

namespace App;

use PDO;
use PDOException;
use function DI\env;

class  Database extends PDO{

    private static $connection = null;

    public static function connection() {
        if (self::$connection === null) {
            try {
                $username = $_ENV['DB_USERNAME'];
                $password = $_ENV['DB_PASSWORD'];

                self::$connection = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], $username, $password);

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die;
            }
        }
        return self::$connection;
    }
}