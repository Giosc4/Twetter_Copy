<!DOCTYPE html>
<html>

<head>
    <title>Titolo della pagina</title>
</head>

<body style="padding-top: 50px">
    <div style="width: 400px; height: 400px; padding: 50px; background-color: lightblue; margin: 0 auto;">

        <?php
        session_start();
        include("../server/functions.php");
        // createHeader();
        ?>
        <form action="../client/login.php" method="post">
            <br>Username: <input type='text' name='username'><br>
            <br>Password: <input type='password' name='password'><br>
            <br><input type='submit' name='login' value='Login'><br>
            <br><input type='submit' name='createAccount' value="Create Account"><br>
        </form>

        <?php if (isset($_POST['login'])) {
            
            $username = $_POST['username'];
            $password = $_POST['password'];

            getLogin($username, $password);

        } 
        
        if(isset($_POST['createAccount'])) {
            header('Location: register.php');
            exit;
        }
        ?>
    </div>
</body>

</html>