<?php
// Definisci le variabili per la connessione
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "twetter_copy";

// Crea la connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla se la connessione è riuscita
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>