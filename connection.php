<?php
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$dbname = "medical_center_db"; // Database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
