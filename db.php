<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sofitra_books";

// Create connection

$conn = new mysqli("localhost", "root", "", "sofitra_books");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
