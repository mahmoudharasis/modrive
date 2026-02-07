<?php

$host = 'localhost';
$user = 'username';
$password = 'password';
$database = 'database_name';

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";
?>