<?php
// Define variables for the connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "(database name)";

// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>