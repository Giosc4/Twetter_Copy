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
        
        <!-- Check if the Username and the password are correct  -->
        <?php include "./logic/login_func.php"; ?>

        <br><button onclick="location.href='signUp.php'">Sign Up</button><br>
        <br><button onclick="location.href='delete_users.php'">DELETE USERS</button><br>

    </form>

</body>

</html>