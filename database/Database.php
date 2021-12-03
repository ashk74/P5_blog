<?php

namespace Database;

use PDO;

/**
 * Class used to create an instance of the database connection
 */
class Database
{
    /**
     * @var null|object $instance Property used to define if an instance of the connection already exists
     */
    private static $instance = null;

    /**
     * @var string Define DBMS, database and host used for connect database
     */
    private const DSN = 'mysql:dbname=p5_blog;host=localhost';

    /**
     * @var string Define username used for connect database
     */
    private const USERNAME = 'root';

    /**
     * @var string Define password used for connect database
     */
    private const PASSWORD = 'toor';

    /**
     * Connect to the database and returns the connection
     *
     * @return PDO object
     */
    public static function dbConnect(): PDO
    {
        // TODO Revoir la video sur la connexion à la BDD pour injection de dépendance
        if (self::$instance === null) {
            self::$instance = new PDO(
                self::DSN,
                self::USERNAME,
                self::PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        }
        return self::$instance;
    }
}
