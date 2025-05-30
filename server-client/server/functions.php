<head>
    <link rel="stylesheet" href="../server/style/functions.css">
</head>
<?php

function getUserData($user)
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
        echo "<p class='empty'>0 results</p>";
        return false;
    }
}
function updateUserData($first_name, $last_name, $email, $user, $pass, $bio)
{
    include("db.php");

    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $bio = mysqli_real_escape_string($conn, $bio);

    $getUserData = "SELECT * FROM users WHERE username='$user'";
    $sql = $conn->query($getUserData);
    $currentData = mysqli_fetch_assoc($sql);

    if (!empty($pass)) {
        $pass = mysqli_real_escape_string($conn, $pass);
    } else {
        $pass = $currentData['password'];

    }

    $sql = "UPDATE users SET first_name=" . ($first_name !== $currentData['first_name'] && !empty($first_name) ? "'$first_name'" : "first_name") . ", last_name=" . ($last_name !== $currentData['last_name'] && !empty($last_name) ? "'$last_name'" : "last_name") . ", email=" . ($email !== $currentData['email'] && !empty($email) ? "'$email'" : "email") . ", password=" . ($pass !== $currentData['password'] && !empty($pass) ? "'$pass'" : "password") . ", bio=" . ($bio !== $currentData['bio'] && !empty($bio) ? "'$bio'" : "bio") . " WHERE username='$user'";

    $result = $conn->query($sql);

    if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['username'] = $user;
        header('Location: ../client/home.php');
    } else {
        echo "ERROR: during data update";
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
    $likeSql = "SELECT * FROM likes WHERE tweet_id = $post_id AND username = '$user_id'";
    $likeResult = $conn->query($likeSql);
    echo "    .    " . $user_id;
    if ($likeResult->num_rows == 0) {
        $insertSql = "INSERT INTO likes (username, tweet_id) VALUES ('$user_id', '$post_id')";
        if ($conn->query($insertSql) === TRUE) {
            echo "Like added successfully.";
            header('Location: ../client/home.php');
        } else {
            echo "Error ";
        }
    } else {
        echo "<p class='empty'>User already liked this tweet</p>";
    }
}

function getTweetsHome($user)
{
    include("db.php");
    $sql = " SELECT * FROM tweets WHERE username IN (SELECT follower_username FROM follows WHERE username = '$user')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $likeSql = "SELECT COUNT(*) as count FROM likes WHERE tweet_id = {$row['tweet_id']}";
            $likeResult = $conn->query($likeSql);
            $likeRow = $likeResult->fetch_assoc();
            $likeCount = $likeRow['count'];
            echo "<div class='tweet-container'>";
            echo "<p class='usernameT'>" . "Username: <button type='submit' name='profileUser' value='" . $row["username"] . "' class='buttonUser'>" . $row["username"] . "</button></p>";
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
        echo "<p class='empty'>0 results</p>";
    }
}


function getMyTweets($user)
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
            echo "<form action='myProfile.php' method='post'>";
            echo "<button type='submit' class='like-button' name='likeTweet' value='" . $row['tweet_id'] . "'>Like</button>";
            if (isAdmin($user)) {
                echo "<button type='submit' class='delete-button' name='deleteTweet' value='" . $row['tweet_id'] . "'>Delete</button>";
            }
            echo "</form></div>";
            echo "<hr>";
        }
    } else {
        echo "<p class='empty'>0 results</p>";
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
        echo "ERROR: during data insertion";
    }
}

function registerAccount($email, $user, $hashPassword, $first_name, $last_name, $bio)
{
    include("db.php");

    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "ERROR: Username already exists";
    } else {
        $sql = "INSERT INTO users (email, username, password, first_name, last_name, bio) VALUES ('$email', '$user', '$hashPassword', '$first_name', '$last_name', '$bio')";
        $result = $conn->query($sql);
        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            return true;
        } else {
            echo "ERROR: during data insertion";
        }
    }
}
function getLogin($user, $psw)
{
    include("db.php");
    $query = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hash = $row['password'];

        if (password_verify($psw, $hash)) {
            $_SESSION['username'] = $user;
            header('Location: ../client/home.php');
            exit();
        } else {
            echo 'Wrong password';
        }
    } else {
        echo "Username not found";
    }
}


function deleteAccount($user)
{
    include("db.php");
    $sql = "DELETE FROM users WHERE username='$user'";
    $result = $conn->query($sql);
    echo $result;
    if (mysqli_affected_rows($conn) > 0) {
        header('Location: ../client/login.php');
        exit;
    } else {
        echo "Error deleting account";
    }
}
function getMyFollowers($user)
{
    include("db.php");
    $sql = "SELECT * FROM users INNER JOIN follows ON users.username = follows.username WHERE follows.follower_username = '$user'";
    $result = $conn->query($sql);
    $followers = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $followers[] = $row;
        }
    }
    return $followers;
}

function isFollowed($user, $userFriend){
    include("db.php");
    $sql = "SELECT follower_username FROM users INNER JOIN follows ON users.username = follows.follower_username WHERE follows.username = '$user'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return true;
    }
    return false;
}

function getMyFollowing($user)
{
    include("db.php");
    $sql = "SELECT * FROM users INNER JOIN follows ON users.username = follows.follower_username WHERE follows.username = '$user'";
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
    $sql = "SELECT username FROM users WHERE username != '$user' AND username NOT IN (SELECT follower_username FROM follows WHERE username = '$user')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>";
            echo "<p class='usernameT'>" . "Username: <button type='submit' name='profileUser' value='" . $row["username"] . "' class='buttonUser'>" . $row["username"] . "</button></p>";
            echo "<form action='home.php' method='post'>";
            echo "<input type='hidden' name='userSelected' value='" . $row["username"] . "'>";
            echo "<button class='follow-button' name='newFollow' type='submit'>Follow</button>";
            echo "</form>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p class='NoUsers'>No users available.</p>";
    }
}

function addFriend($user, $friend_username)
{
    include("../server/db.php");
    $sql = "INSERT INTO follows (username, follower_username) VALUES ('$user', '$friend_username')";
    $result = $conn->query($sql);
    if ($result) {
        echo "Follow Added!";
    } else {
        echo "Error: adding follow";
    }
    $conn->close();
}

function removeFriend($user, $friend_username)
{
    echo $user;
    echo $friend_username;
    include("../server/db.php");
    $sql = "DELETE FROM follows WHERE username = '$user' AND follower_username = '$friend_username'";
    if (!$conn->query($sql)) {
        echo "Error: removing follow" ;
    } else {
        echo "Follow Removed!";
    }
}

function searchBar_user($request)
{
    include("db.php");
    $query = mysqli_real_escape_string($conn, $request);
    $sql = "SELECT * FROM users WHERE username LIKE '%$query%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p class='username_name'>Username: " . $row['username'] . "</p><br>";
            echo "<p class='username'>Name: " . $row['first_name'] . "<br>Surname: " . $row['last_name'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Bio: " . $row['bio'] . "</p><br>";

        }
    } else {
        echo "No results";
    }
}

function searchBar_tweets($request)
{
    include("db.php");
    $query = mysqli_real_escape_string($conn, $request);
    $sql = "SELECT u.username, t.text FROM users u LEFT JOIN tweets t ON u.username = t.username WHERE u.username LIKE '%$query%' OR t.text LIKE CONCAT('%', '%$query%', '%') ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (stripos($row['text'], $request) !== false) {
                echo "<p class='username_name'>Username: " . $row['username'] . "</p>";
                echo "<p class='tweet_text'>Tweets: " . $row['text'] . "</p><br>";
            }
        }
    } else {
        echo "No results";
    }
}

function deleteTweet($tweetId)
{
    include("db.php");
    $sql = "DELETE FROM tweets WHERE tweet_id = '$tweetId'";
    $result = $conn->query($sql);
    if ($result) {
        header('Location: ../client/home.php');
    } else {
        echo "ERROR: while deleting tweet";
    }
}
?>