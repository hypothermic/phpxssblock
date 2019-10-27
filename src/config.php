<?php
namespace HypothermicIT\XSSBlock;

class Config {

    /**
     * Whether to enable debug behaviour (messages, etc.) or not.
     *
     * @var bool
     */
    public static $DEBUG_ENABLE = FALSE;

    /**
     * A database setting.
     *
     * @var string
     */
    public static $DATABASE_HOST     = "localhost",
                  $DATABASE_USERNAME = "xssblock-user",
                  $DATABASE_PASSWORD = "change_me!",
                  $DATABASE_NAME     = "XSSBlock",
                  $DATABASE_TABLE    = "Registry";

    /**
     * Which patterns to block.
     *
     * @var string[]
     */
    public static $BLOCKED_PATTERNS = ["<script>", "</script>",
                                       "<applet>", "</applet>",
                                       "<style>",  "</style>",
                                       "<link>",   "</link>",
                                       "<iframe>", "</iframe>",
                                       "<img>",    "</img>",
                                       "<frame>",  "</frame>",
                                       "<form>",   "</form>",
                                       "<meta>",   "<svg/onload"];

    /**
     * The maximum size for an input string.
     *
     * @var int
     */
    public static $MAX_STR_LEN = 8192;

}