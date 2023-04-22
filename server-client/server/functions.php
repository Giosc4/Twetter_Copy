<head>
    <link rel="stylesheet" href="../server/style/functions.css">
</head>

<?php

function getDataUtente($user)
{
    include("db.php");

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["username"] == $user) {

                echo "<ul>";
                echo "<li><strong>Name:</strong> " . $row["first_name"] . "</li>";
                echo "<li><strong>Surname:</strong> " . $row["last_name"] . "</li>";
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

    while ($row = $result->fetch_assoc()) {
        $OLDfirst_name = $row["first_name"];

        $OLDlast_name = $row["last_name"];

        $OLDemail = $row["email"];

        $OLDpassword = $row["password"];

        $OLDbio = $row["bio"];
    }

    // Aggiorna i dati utente nella tabella users
    $sql = "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email', password='$password', bio='$bio' WHERE username='$user'";
    $result = $conn->query($sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['username'] = $user;
        header('Location: ../client/home.php');
        exit;
    } else {
        // Si è verificato un errore durante l'aggiornamento dei dati, restituisci un messaggio di errore
        echo "ERRORE: durante l'aggiornamento dei dati";
        exit;
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


function addLiketoTweet($user_id, $post_id)
{
    include("db.php");

    // Controlla se l'utente ha già messo like a questo tweet
    $likeSql = "SELECT * FROM likes WHERE tweet_id = $post_id AND username = '$user_id'";
    $likeResult = $conn->query($likeSql);
    echo "    .    " . $user_id;

    if ($likeResult->num_rows == 0) {
        // Aggiungi un like al tweet
        $insertSql = "INSERT INTO likes (username, tweet_id) VALUES ('$user_id', '$post_id')";
        if ($conn->query($insertSql) === TRUE) {
            echo "Like added successfully.";
            header('Location: ../client/home.php');

        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    } else {
        echo "User already liked this tweet.";
    }
}


function getTweetsHomeNotMine($user)
{
    include("db.php");

    $sql = "SELECT * FROM tweets WHERE tweets.username <> '$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $likeSql = "SELECT COUNT(*) as count FROM likes WHERE tweet_id = {$row['tweet_id']}";
            $likeResult = $conn->query($likeSql);
            $likeRow = $likeResult->fetch_assoc();
            $likeCount = $likeRow['count'];

            echo "<div class='tweet-container'>";
            echo "<p class='usernameT'>" . "Username: " . $row["username"] . "</p>";
            echo "<p class='textT'>" . "Text: " . $row["text"] . "</p>";
            echo "<p class='created_atT'>" . "Created At: " . $row["created_at"] . "</p>";
            echo "<p class='like-count'>" . "Likes: " . $likeCount . "</p>";
            echo "<form action='home.php' method='post'>";
            echo "<button type='submit' class='like-button' name='likeTweet' value='" . $row['tweet_id'] . "'>Like</button>";
            if (isAdmin($user)) {
                echo "<button type='submit' class='delete-button' name='deleteTweet' value='" . $row['tweet_id'] . "'>Delete</button>";
            }
            echo "</form></div>";
            echo " <hr>";
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
            $likeSql = "SELECT COUNT(*) as count FROM likes WHERE tweet_id = {$row['tweet_id']}";
            $likeResult = $conn->query($likeSql);
            $likeRow = $likeResult->fetch_assoc();
            $likeCount = $likeRow['count'];

            echo "<div class='tweet-container'>";
            echo "<p class='usernameT'>" . "Username: " . $row["username"] . "</p>";
            echo "<p class='textT'>" . "Text: " . $row["text"] . "</p>";
            echo "<p class='created_atT'>" . "Created At: " . $row["created_at"] . "</p>";
            echo "<p class='like-count'>" . "Likes: " . $likeCount . "</p>";
            echo "<form action='profile.php' method='post'>";
            echo "<button type='submit' class='like-button' name='likeTweet' value='" . $row['tweet_id'] . "'>Like</button>";
            if (isAdmin($user)) {
                echo "<button type='submit' class='delete-button' name='deleteTweet' value='" . $row['tweet_id'] . "'>Delete</button>";
            }
            echo "</form></div>";
            echo "<hr>";
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
        return true;
    } else {
        echo "ERRORE: durante l'inserimento dei dati ";
    }
}

function registerAccount($email, $user, $password, $first_name, $last_name, $bio)
{
    include("db.php");

    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "ERRORE: Username già esistente ";

    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (email, username, password, first_name, last_name, bio) VALUES ('$email', '$user', '$password_hash', '$first_name', '$last_name', '$bio')";
        $result = $conn->query($sql);

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            return true;
        } else {
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
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            exit;
        } else {
            echo 'Password errata';
            // sleep(1);
            // header("Location: login.php");
            exit;
        }
    } else {
        echo "Username non esistente";
        exit;
    }
}

function deleteAccount($user)
{
    include("db.php");

    $sql = "DELETE FROM users WHERE username='$user'";
    $result = $conn->query($sql);
    echo $result;
    if (mysqli_affected_rows($conn) > 0) {
        echo "Account eliminato";
        // header("Location: login.php");
        exit;
    } else {
        echo "Errore durante l'eliminazione dell'account";
        exit;
    }
}



function getMyFollowers($user)
{
    include("db.php");

    $sql = "SELECT follower_username
    FROM follows
    WHERE username = '$user' AND follower_username != '$user';
    ";

    $result = $conn->query($sql);

    $followers = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $followers[] = $row;
        }
    }
    return $followers;
}



function getMyFollowing($user)
{
    include("db.php");

    $sql = "SELECT username FROM follows WHERE follower_username = '$user' AND username != '$user';";

    $result = $conn->query($sql);

    $followed = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $followed[] = $row;
        }
    }
    return $followed;
}

function getUserListHome($user)
{
    include("db.php");

    // $sql = "SELECT username FROM users WHERE username NOT IN (SELECT follower_username FROM follows WHERE user_id = '$user') AND username != '$user'";
    $sql = "SELECT username FROM users WHERE username NOT IN ( SELECT username FROM follows WHERE follower_username = '$user' ) AND username != '$user'";
        $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            $userFriend = $row["username"];
            echo "<form action='home.php' method='post'>";
            // IL PROBLEMA è QUA 
            echo "<li><span class='username' value='friend_username'>Username: " . $row["username"] . "</span><button class='follow-button' name='user_id' value='" . $row['username'] . "'>Segui</button></li>";
            echo "</form>";
        }
        echo "</ul>";
        if (isset($_POST['newFollow'])) {
            $friend_username = $_POST['friend_username'];
            include("db.php");

            $sql = "INSERT INTO follows (follower_username, following_username) VALUES ('$user', '$friend_username')";
            if (mysqli_query($conn, $sql)) {
                echo "NEW FRIEND ADDED!";
            } else {
                echo "Errore: " . $sql . "<br>" . mysqli_error($conn);
            }
            exit();
        }


    } else {
        echo "<p class='NoUsers'>Non ci sono utenti disponibili.</p>";
    }
}





?>