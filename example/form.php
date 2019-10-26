<?php

use HypothermicIT\XSSBlock\XBlock;

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
        <title>Title</title>
    </head>
    <body>

    </body>
</html>