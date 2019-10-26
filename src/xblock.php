<?php
namespace HypothermicIT\XSSBlock;

use DB_Impl_MySQL;

class XBlock {

    // Use MySQL/MariaDB by default.
    private static $DATABASE_IMPL = DB_Impl_MySQL::class;

    /**
     * @var Database
     */
    private static $DATABASE_INST = null;

    /**
     * Checks if the IP address is listed in the block database
     *
     * @param $ip_address string An IPv4 or IPv6 address (max 45 char)
     * @return boolean;
     */
    public static function isBlocked($ip_address) {
        // Validate the input IP address.
        if (is_null($ip_address) || !is_string($ip_address)) {
            error_log("[XSSBlock] XBlock::isBlocked - IP Address must be a string! Rejecting this attempt.");
            return TRUE;
        }
        $len = strlen($ip_address);
        if ($len < 12 || $len > 45) {
            error_log("[XSSBlock] XBlock::isBlocked - IP Address is not between accepted range (12-45)! Rejecting this attempt.");
            return TRUE;
        }

        // Instantiate the database connection if not available.
        if (self::$DATABASE_INST == null) {
            self::$DATABASE_INST = new self::$DATABASE_IMPL;
            self::$DATABASE_INST->initialize();
        }
        // Check in the database and return the result.
        return self::$DATABASE_INST->isBlocked($ip_address);
    }

    /**
     * Set which implementation to use for the database.
     *
     * @param $database_class Database A class implementing database
     */
    public static function setDatabase($database_class) {
        self::$DATABASE_IMPL = $database_class;
    }
}