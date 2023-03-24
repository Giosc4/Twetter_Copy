<!DOCTYPE html>
<html>

<head>
    <title>Titolo della pagina</title>
    <link rel="stylesheet" href="../server/styleLogin.css">

</head>

<?php
session_start();
include("../server/functions.php");
// createHeader();
?>

<body>
    <div class="login-form">
        <form action="../client/login.php" method="post">
            <br>Username: <input type='text' name='username'><br>
            <br>Password: <input type='password' name='password'><br>
            <br><input type='submit' name='login' value='Login'><br>
            <br><input type='submit' name='createAccount' value="Create Account"><br>
            <?php if (isset($_POST['login'])) {

                $username = $_POST['username'];
                $password = $_POST['password'];

                $resutl = getLogin($username, $password);
                if ($resutl == true) {
                    header('Location: home.php');
                    exit;
                } else {
                    echo "Login fallito";
                }

            }

            if (isset($_POST['createAccount'])) {
                header('Location: register.php');
                exit;
            }
            ?>
        </form>
    </div>
</body>



</html>