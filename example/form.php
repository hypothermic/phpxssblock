<?php

// Include all the dependencies:
use HypothermicIT\XSSBlock\XBlock;
include_once("../src/xblock.php");
include_once("../src/database.php");
include_once("../src/db_impl_mysql.php");
include_once("../config.php");

if (XBlock::isBlocked($_SERVER['REMOTE_ADDR'])) {
    include 'error-page.html';
    exit(1);
}

?>

<!-- TODO in this example: get all $_GET and $_POST through the XBlock::GET and XBlock::POST wrapper methods !!!-->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Protected Web Form</title>
    </head>
    <body>

        <h1>My Awesome Web Form</h1>
        <p>Do not attempt to perform Cross Site Scripting attacks on this form or you'll get banned!</p><br />

        <?php
            /* If form hasn't been filled out yet, display it */
            if (!isset($_GET["submit"])) {
        ?>

            <form action="form.php" method="get">
                Please enter your full name:
                <label>
                    <input type="text" name="username"><br />
                </label>

                What are your recommendations:
                <label>
                    <textarea name="notes"></textarea><br />
                </label>

                <input type="submit" name="submit" value="Submit!">
            </form>

        <?php
            /* Else, process the data and show a response */
            } else {
                echo(XBlock::Sanitize($_GET["username"], $_SERVER['REMOTE_ADDR']) .
                     ", thank you for submitting your response: \"" .
                     XBlock::Sanitize($_GET["notes"], $_SERVER['REMOTE_ADDR']) . "\"");
            }
        ?>

    </body>
</html>