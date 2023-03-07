<!-- GIOVANNI MARIA SAVOCA -->

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>


<body>
    <h1>Login Profile</h1>

    <form action="login.php" method="post">
        <p>Username: <input type="text" name="username" required></p>
        <p>Password: <input type="password" name="password" required></p>
        <p><input type="submit" name="login"></p>
        <br><button onclick="location.href='signUp.php'">Sign Up</button>


        <!-- id	email	username	password	first_name	last_name	bio	profile_picture -->


        <?php
        session_start();
        include 'db.php';

        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $password =  $row['password'];
                    $_SESSION['username'] = $username;
                    header('Location: home_page.php');
                    exit();
                } else {
                    echo 'Password errata';
                }
            }

            echo 'Username o password errati';
        }

        mysqli_close($conn);
        ?>

    </form>
    <br><button onclick="location.href='delete_users.php'">DELETE USERS</button><br>

</body>

</html>