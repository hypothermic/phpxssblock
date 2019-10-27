<?php
namespace HypothermicIT\XSSBlock;

use HypothermicIT\XSSBlock\Database;
use HypothermicIT\XSSBlock\Config;
use \PDO;
use PDOException;

class DB_Impl_MySQL implements Database {

    /**
     * The database connection object.
     *
     * @var PDO
     */
    private $connection;

    /**
     * Add a client block listing to the database.
     *
     * @param $ip_address string Client IP-Address value
     * @return void
     */
    public function addBlock($ip_address) {
        $sql = 'INSERT INTO `' . Config::$DATABASE_NAME . "`.`" . Config::$DATABASE_TABLE . '` (`ip_addr`) VALUES (?)';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(1, $ip_address, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Check if a client is listed as blocked in the database.
     *
     * @param $ip_address string Client IP-Address value
     * @return bool True if ip_address is blocked, false if not blocked.
     */
    public function isBlocked($ip_address) {
        // TODO: Implement isBlocked() method.
        $sql = 'SELECT 1 from `' . Config::$DATABASE_NAME . "`.`" . Config::$DATABASE_TABLE . '` WHERE `ip_addr` = ? LIMIT 1';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(1, $ip_address, PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->fetchColumn()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Initializes the database connection if required.
     *
     * @return void
     */
    public function initialize() {
        $this->getConnection();
    }

    /**
     * Creates a PDO instance if $this->connection is null;
     *
     * @return PDO A connection handle to the database
     */
    private function getConnection() {
        if ($this->connection == null) {
            try {
                $this->connection = new PDO("mysql:host=" . Config::$DATABASE_HOST . ";dbname=" . Config::$DATABASE_NAME, Config::$DATABASE_USERNAME, Config::$DATABASE_PASSWORD);
                $this->connection->exec("set names utf8");
            } catch (PDOException $exception) {
                error_log("Connection error: " . $exception->getMessage());
            }
            if (Config::$DEBUG_ENABLE && $this->connection != null) {
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }

        return $this->connection;
    }
}