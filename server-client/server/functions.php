<head>
    <link rel="stylesheet" href="../server/style/home.css">
</head>
<?php



function getDataUtente($user)
{
    include("db.php");

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo " <h2>Dati utente " . $user . "</h2>";
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] == $user) {

                echo "<ul>";
                echo "<li><strong>Nome:</strong> " . $row["first_name"] . "</li>";
                echo "<li><strong>Cognome:</strong> " . $row["last_name"] . "</li>";
                echo "<li><strong>Email:</strong> " . $row["email"] . "</li>";
                echo "<li><strong>Bio:</strong> " . $row["bio"] . "</li>";
                echo "</ul>";

                return true;
            }
        }
    } else {
        echo "0 results";
        return false;
    }

}

function updateDataUtente($first_name, $last_name, $email, $user, $password, $bio)
{
    include("db.php");

    // Verifica se il nuovo username esiste già nel database
    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Username già esistente";
        return true;
    } else {
        while ($row = $result->fetch_assoc()) {
            if ($first_name == "") {
                $first_name = $row["first_name"];
            }
            if ($last_name == "") {
                $last_name = $row["last_name"];
            }
            if ($email == "") {
                $email = $row["email"];
            }
            if ($password == "") {
                $password = $row["password"];
            }
            if ($bio == "") {
                $bio = $row["bio"];
            }
        }
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Aggiorna i dati utente nella tabella users
        $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', password='$password_hash', bio='$bio' WHERE username='$oldUsername'";
        $result = $conn->query($sql);

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['username'] = $user;
            header('Location: ../client/profile.php');
            exit;
        } else {
            // Si è verificato un errore durante l'aggiornamento dei dati, restituisci un messaggio di errore
            echo "ERRORE: durante l'aggiornamento dei dati";
            exit;
        }
    }
}


function isAdmin($user)
{
    include("db.php");


    $sql = "SELECT users.isAdmin FROM users WHERE users.username = '$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["isAdmin"] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

}

function getTweetsHomeNotMine($user)
{
    include("db.php");

    $sql = "SELECT * FROM tweets WHERE tweets.username <> '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] != $user) {
                echo "<div class='tweet-container'>";
                echo "<p class='usernameT'>" . "Username: " . $row["username"] . "</p>";
                echo "<p class='textT'>" . "Text: " . $row["text"] . "</p>";
                echo "<p class='created_atT'>" . "Created At: " . $row["created_at"] . "</p>";
                echo "<form action='home.php' method='post'>";
                if (isAdmin($user)) {
                    echo "<button type='submit' class='delete-button' name='deleteTweet' value='" . $row['tweet_id'] . "'>Delete</button>";
                }
                echo "</form></div>";
                echo "<br> <hr>";
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

    $wantDelate;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] == $user) {
                echo "<div class='tweet-container'>";
                echo "<p class='usernameT'>" . "Username: " . $row["username"] . "</p>";
                echo "<p class='textT'>" . "Text: " . $row["text"] . "</p>";
                echo "<p class='created_atT'>" . "Created At: " . $row["created_at"] . "</p>";
                echo "<form action='home.php' method='post'>";
                if (isAdmin($user)) {
                    echo "<button type='submit' class='delete-button' name='deleteTweet' value='" . $row['tweet_id'] . "'>Delete</button>";
                }
                echo "</form></div>";
                echo "<br> <hr>";
            }
        }
        
    } else {
        echo "0 results";
    }
}





function writeTweetHome($user, $text)
{
    include("db.php");
    $user = mysqli_real_escape_string($conn, $user);
    $text = mysqli_real_escape_string($conn, $text);
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