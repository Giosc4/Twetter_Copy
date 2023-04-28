<!DOCTYPE html>
<html>
<!-- 
    THINGS TO DO:
        - update User button not working
        - updateDataUtente not working
        - home footer
        - check follower and following functionality 
        - check Unfollow functionality
            - search bar 
        if I don't follow a user and I search for them, I can't find them
        ----
        COSE DA FARE:
        - non funziona il pulsante update User
        - updateDataUtente non funziona
        - footer home
        - controllare bene i follower e following 
        - controllare il UnFOllow

        - search bar 
            se non seguo un utente e lo cerco, non lo trovo
            
-->

<head>
    <title>Twitter Copy Login</title>
    <link rel="stylesheet" href="../server/style/login.css">
</head>
<?php
session_start();
include("../server/functions.php");
?>

<body>
    <div class="loginClass">
        <h1>LOGIN</h1>
        <div class="login-form">
            <form action="../client/login.php" method="post">
                <br>Username: <input type='text' name='username'><br>
                <br>Password: <input type='password' name='password'><br>
                <br><button name='loginBtn'>Login</button>
                <?php
                if (isset($_POST['loginBtn'])) {
                    $user = $_POST['username'];
                    $psw = $_POST['password'];

                    getLogin($user, $psw);
                    
                } ?>
                <br>

                <hr><button name='createAccount'>Create Account</button><br>
            </form>
        </div>
    </div>
    <?php include_once("../server/footer.php"); ?>
    <?php
    if (isset($_POST['createAccount'])) {
        echo "account ";
        header('Location: register.php');
        exit;
    }
    ?>
</body>

</html>