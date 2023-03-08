<?php
session_start();
if (isset($_SESSION['username'])) {
    // La sessione è stata avviata correttamente
    $username = $_SESSION['username'];
    echo "<h1>Welcome, $username!</h1>";
} else {
    header('Location: ../client/start.php');
    exit;
}


include('db.php');

//from start.php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $password = $row['password'];
            $_SESSION['username'] = $username;
            header('Location: ../client/home.php');
            exit();
        } else {
            echo 'Password errata';
        }
    }

    echo 'Username o password errati';
}

//from profile.php
if (isset($_POST["change"])) {
    $old_username = $_SESSION['username'];

    $new_username = $_POST['username'];
    $new_password = $_POST['password'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_email = $_POST['email'];
    $new_bio = $_POST['bio'];

    // Controlla che i campi obbligatori siano stati compilati
    if (empty($new_username) || empty($new_password) || empty($new_email)) {
        echo "Username, password, and email are required fields.";
        exit;
    }

    // Crittografa la password
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // query di aggiornamento
    $queryUpdate = "UPDATE users SET username = '$new_username', password = '$password_hash', first_name = '$new_first_name', last_name = '$new_last_name', email = '$new_email', bio = '$new_bio' WHERE username = $old_username";
    $result = $conn->query($queryUpdate);

    if ($result) {
        echo "Dati aggiornati con successo";
        session_destroy();
        header('Location: login.php');

    } else {
        echo "Errore durante l'aggiornamento dei dati: " . $conn->error;
    }
}

//from home.php
if (isset($_POST['salva'])) {
    $text = $_POST['text'];

    if (isset($_SESSION['username']) && $username == $_SESSION['username']) {
        include("db.php");
        $sql = "INSERT INTO tweets (user_id, text) VALUES ( '$username', '$text')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
}

//from header.php
if (isset($_POST['home'])) {
    // gestisci il click sul pulsante Home
    header('Location: ../client/home.php');
} 

if (isset($_POST['profile'])) {
    // gestisci il click sul pulsante Profile
    header('Location: ../client/profile.php');
} 

if (isset($_POST['logout'])) {
    // gestisci il click sul pulsante Logout
    session_start();
    session_destroy();
    header('Location: ../client/start.php');
}



mysqli_close($conn);


?>