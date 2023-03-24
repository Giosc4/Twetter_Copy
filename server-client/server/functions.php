<head>
  <link rel="stylesheet" href="../server/styleHome.css">
</head>
<?php

function getTweetsHomeNotMine($user)
{
    include("db.php");
    


    $sql = "SELECT * FROM tweets, users WHERE users.username <> '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] != $user) {
                echo "<div class='tweet-container'>";
                echo "<p class='usernameT'>" ."Username: " . $row["username"] . "</p>";
                echo "<p class='textT'>" ."Text: " . $row["text"] . "</p>";
                echo "<p class='created_atT'>" ."Created At: " . $row["created_at"] . "</p>";
                echo "</div>";
                echo "<br>";
            }
        }
    } else {
        echo "0 results";
    }
}

function getTweetsHomeMine($user)
{
    include("db.php");


    $sql = "SELECT * FROM tweets WHERE tweets.username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo " <h2>My Tweets</h2>";
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] == $user) {
                echo "<div class='tweet-container'>";
                echo "<p class='usernameT'>" ."Username: " . $row["username"] . "</p>";
                echo "<p class='textT'>" ."Text: " . $row["text"] . "</p>";
                echo "<p class='created_atT'>" ."Created At: " . $row["created_at"] . "</p>";
                echo "</div>";
                echo "<br>";
            }
        }
    } else {
        echo "0 results";
    }
}


function writeTweetHome($user, $text)
{
    include("db.php");
    $sql = "INSERT INTO tweets (username, text) VALUES ('$user', '$text')";
    $result = $conn->query($sql);

    if (mysqli_affected_rows($conn) > 0) {
        // Se l'inserimento dei dati è andato a buon fine, restituisci true
        return true;
    } else {
        // Si è verificato un errore durante l'inserimento dei dati, restituisci un messaggio di errore
        echo "ERRORE: durante l'inserimento dei dati ";
    }

}



function registerAccount($email, $user, $password, $first_name, $last_name, $bio)
{
    include("db.php");

    // Verifica se l'username esiste già nel database
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "ERRORE: Username già esistente ";
        echo $sql;

    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, username, password, first_name, last_name, bio) VALUES ('$email', '$user', '$password_hash', '$first_name', '$last_name', '$bio')";
        $result = $conn->query($sql);

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            return true;
        } else {
            // Si è verificato un errore durante l'inserimento dei dati, restituisci un messaggio di errore
            echo "ERRORE: durante l'inserimento dei dati ";
        }

    }
}




function getLogin($user, $password)
{
    include("db.php");

    $query = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($query);

    if (mysqli_affected_rows($conn) > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $password = $row['password'];
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            return;
        } else {
            return 'Password errata';
        }
    }
}
?>
<?php

// function getTweetsProfile()
// {
//     include("db.php");

//     $sql = "SELECT * FROM tweets, users WHERE user_id = username";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             if ($row["username"] == $_SESSION["username"]) {
//                 echo "<div style='border: 1px solid black; padding: 10px; width: 500px;'>";
//                 echo "Username: " . $row["username"] . "<br>Text: " . $row["text"] . "<br>Created At: " . $row["created_at"] . "<br>";
//                 echo "</div>";
//             }
//         }
//     } else {
//         echo "0 results";
//     }
// }

?>