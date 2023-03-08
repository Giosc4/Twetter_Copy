<?php
include './logic/db.php';
$conn = new mysqli("localhost", "root", "", "internetetoutils");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

if (isset($_POST["submit"]) && $_POST["submit"] == "Elimina") {
    // Eliminazione della riga corrispondente all'ID selezionato
    $username = $_POST["username"];
    $sql = "DELETE FROM users WHERE username = '$username'";
    if ($conn->query($sql) !== TRUE) {
        echo "Errore durante l'eliminazione della riga: " . $conn->error;
    }
}

// Query per ottenere l'elenco degli utenti
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // Creazione dei pulsanti di opzione per gli utenti esistenti
    while ($row = $result->fetch_assoc()) {
        echo "<input type='radio' name='username' value='" . $row["username"] . "'>" . $row["username"] . "<br>";
    }
    echo "<br><input type='submit' name='submit' value='Elimina'>";
} else {
    echo "Nessun risultato";
}
$conn->close();
?>