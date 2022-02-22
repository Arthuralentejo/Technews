<?php
namespace App\Utils;

use PDO;
use PDOException;

/**
 * Class DBConnector
 *
 * @package App\Utils
 */
class DBConnector
{

    /**
     * @var string
     */
    private static string $host;
    /**
     * @var string
     */
    private static string $name;
    /**
     * @var string
     */
    private static string $user;
    /**
     * @var string
     */
    private static string $password;
    /**
     * @var PDO
     */
    private static PDO $connection;

    /**
     * @return void
     */
    private static function initValues(){
        self::$host = getenv('DB_HOST');
        self::$name = getenv('DB_NAME');
        self::$user = getenv('DB_USER');
        self::$password = getenv('DB_PASSWORD');
    }
    public static function getInstance(): PDO{
        if (!isset(self::$connection)){
            self::initValues();
            self::connect();
        }
        return self::$connection;
    }

    /**
     * @return void
     */
    private static function connect(): void
    {
        try {
            self::$connection = new PDO("pgsql:host=" . self::$host . ";dbname=" . self::$name, self::$user, self::$password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }

    }
}
