<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "praktek_industri";

    $db = new mysqli($servername, $username, $password, $dbname);

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

?>