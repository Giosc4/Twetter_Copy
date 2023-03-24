<?php
session_start();
exit();

// include('db.php');

//from start.php




// //from header.php
// if (isset($_POST['home'])) {
//     // gestisci il click sul pulsante Home
//     header('Location: ../client/home.php');
// } 







//from profile.php
// if (isset($_POST["change"])) {
//     $old_username = $_SESSION['username'];

//     $new_username = $_POST['username'];
//     $new_password = $_POST['password'];
//     $new_first_name = $_POST['first_name'];
//     $new_last_name = $_POST['last_name'];
//     $new_email = $_POST['email'];
//     $new_bio = $_POST['bio'];

//     // Controlla che i campi obbligatori siano stati compilati
//     if (empty($new_username) || empty($new_password) || empty($new_email)) {
//         echo "Username, password, and email are required fields.";
//         exit;
//     }

//     // Crittografa la password
//     $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

//     // query di aggiornamento
//     $queryUpdate = "UPDATE users SET username = '$new_username', password = '$password_hash', first_name = '$new_first_name', last_name = '$new_last_name', email = '$new_email', bio = '$new_bio' WHERE username = $old_username";
//     $result = $conn->query($queryUpdate);

//     if ($result) {
//         echo "Dati aggiornati con successo";
//         session_destroy();
//         header('Location: login.php');

//     } else {
//         echo "Errore durante l'aggiornamento dei dati: " . $conn->error;
//     }
// }

// //from home.php
// if (isset($_POST['salva'])) {
//     $text = $_POST['text'];

//     if (isset($_SESSION['username']) && $username == $_SESSION['username']) {
//         include("db.php");
//         $sql = "INSERT INTO tweets (user_id, text) VALUES ( '$username', '$text')";

//         if ($conn->query($sql) === TRUE) {
//             echo "New record created successfully";
//         } else {
//             echo "Error: " . $sql . "<br>" . $conn->error;
//         }
//         $conn->close();
//     }
// }





// mysqli_close($conn);
?>