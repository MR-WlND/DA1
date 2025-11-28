<?php
class Database
{
    private static $host = 'localhost';
    private static $db   = 'da1';
    private static $user = 'root';
    private static $pass = '';
    private static $charset = 'utf8';

    private static $pdo = null;

    public static function connect()
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            try {
                self::$pdo = new PDO($dsn, self::$user, self::$pass);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
