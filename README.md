# PHP XSS Blocker

Block the IP Addresses of clients who are trying to exploit your website by using XSS.

## Usage

### Automatic usage

```php
TODO create an automatic method in XBlock
```

### Manual usage

At the top of each page, put:

```php
<?php
use HypothermicIT\XSSBlock\XBlock;

if (XBlock::isBlocked($_SERVER['REMOTE_ADDR'])) {
    include 'my-error-page.html';
    exit();
}
?>
```

And, when handling user input, validate each `$_GET` and `$_POST` through the XBlock Wrapper Methods:

```php
TODO
```

## Database

This library requires a database to store the list of blocked IP's.
It is very simple to set up the database, and an implementation for MySQL/MariaDB is included by default.
You will only need to create the database user and you're set.

By default, the MySQL implementation will try to connect to `localhost:3306` with user `xssblock-user`.
You may change the settings in [`src/db_impl_mysql.php`](src/db_impl_mysql.php)