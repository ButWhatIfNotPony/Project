<?php
    // Database credentials. Assuming you are running MYSQL
    // server with default setting (user 'root' with no password)
    $DB_SERVER   = "localhost";
    $DB_USERNAME = "root";
    $DB_PASSWORD = "PoNiEs1080";
    $DB_NAME     = "Project";

    // Attempt to connect to MySQL database
    try {
        $pdo = new PDO("mysql:host=$DB_SERVER;dbname=$DB_NAME", $DB_USERNAME, $DB_PASSWORD);
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("ERROR: Could not connect. " . $e->getMessage());
    }
?>