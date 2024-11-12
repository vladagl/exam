<?php
$mysqli = new mysqli("localhost", "root", "", "product_reviews");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
