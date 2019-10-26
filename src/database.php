<?php
namespace HypothermicIT\XSSBlock;

interface Database {

    /**
     * Initializes the database and creates the table (if needed)
     */
    public function initialize();

    /**
     * Add a client block listing to the database.
     *
     * @param $ip_address string Client IP-Address String
     */
    public function addBlock($ip_address);

    /**
     * Check if a client is blocked in the database.
     *
     * @param $ip_address string Client IP-Address String
     * @return bool True if ip_address is blocked, false if not blocked.
     */
    public function isBlocked($ip_address);

}