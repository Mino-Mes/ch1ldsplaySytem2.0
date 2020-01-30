<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "chi1dsplay_web_system";

// Create connection
$conn = new mysqli($servername, $username, "", $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
