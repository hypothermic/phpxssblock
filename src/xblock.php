<?php
namespace HypothermicIT\XSSBlock;

use DB_Impl_MySQL;

class XBlock {

    /**
     * The default value is the MySQL/MariaDB driver class.
     *
     * @var string Class constant reference.
     */
    private static $DATABASE_IMPL = DB_Impl_MySQL::class;

    /**
     * @var Database
     */
    private static $DATABASE_INST = null;

    /**
     * Adds the IP address to the block database
     *
     * @param $ip_address string An IPv4 or IPv6 address (max 45 char)
     * @return void
     */
    public static function addBlock($ip_address) {
        // Validate the input IP address.
        if (is_null($ip_address) || !is_string($ip_address)) {
            error_log("[XSSBlock] XBlock::addBlocked - IP Address must be a string! Rejecting this attempt.");
            return;
        }
        $len = strlen($ip_address);
        if ($len < 7 || $len > 45) {
            error_log("[XSSBlock] XBlock::addBlocked - IP Address is not between accepted range (7-45)! Rejecting this attempt.");
            return;
        }

        // Check in the database and return the result.
        self::getDatabase()->addBlock($ip_address);
    }

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
        if ($len < 7 || $len > 45) {
            error_log("[XSSBlock] XBlock::isBlocked - IP Address is not between accepted range (7-45)! Rejecting this attempt.");
            return TRUE;
        }

        // Check in the database and return the result.
        return self::getDatabase()->isBlocked($ip_address);
    }

    /**
     * Set which implementation to use for the database.
     *
     * If a connection to a database is open, it will be closed.
     *
     * @param $database_class Database A class implementing database
     */
    public static function setDatabase($database_class) {
        self::$DATABASE_IMPL = $database_class;
        self::$DATABASE_INST = null;
    }

    /**
     * Initiates the database connection if non exists yet.
     *
     * @return Database
     */
    private static function getDatabase() {
        // Instantiate the database connection if not available.
        if (self::$DATABASE_INST == null) {
            self::$DATABASE_INST = new self::$DATABASE_IMPL;
            self::$DATABASE_INST->initialize();
        }
        return self::$DATABASE_INST;
    }

    /**
     * Usage: `$name = XBlock::Sanitize($_GET["name"]);`
     *
     * This method checks if the value is set and valid.
     *
     * If the value contains critical HTML, like script tags, the user gets banned.
     * (see <i>config.php</i> for the blocked patterns)
     *
     * @param $raw_value          string   the unsanitized value
     * @param $client_ip_address  string   the user's IP address
     * @return                    string   sanitized value, or an empty string if not successful.
     */
    public static function Sanitize($raw_value, $client_ip_address) {
        // Verify that the input is a string
        if (!isset($raw_value)) {
            return "";
        }
        if (is_string($raw_value) && strlen($raw_value) > MAX_STR_LEN) {
            return "";
        }

        // Check if the raw input string contains any blocked patterns
        $without_whitespace = preg_replace('/\s+/', '', $raw_value);
        foreach (BLOCKED_PATTERNS as $blocked_pattern) {
            // If it contains a blocked pattern
            if (strpos($without_whitespace, $blocked_pattern) !== false) {

                // Block the client.
                self::addBlock($client_ip_address);

                // Attempt to refresh the page so the red screen shows up.
                // If this doesn't work it's not a huge problem, the client will still be blocked.
                echo '<script type="text/javascript">location.reload(true);</script><meta http-equiv="refresh" content="0">';

                // Exit the script to prevent any (additional) damage
                exit();
            }
        }

        // Return the sanitized string
        return htmlspecialchars(strip_tags($raw_value));
    }
}