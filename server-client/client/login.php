<!DOCTYPE html>
<html>

<!-- 
    COSE DA FARE:
        - Aggiungere una barra di ricerca di tweet
        - Aggiungere una tabella per seguire gli utenti
        - non funziona il pulsante elimina utente
        - non funziona il pulsante update User
        - la lista di utenti nella home è sbaligata, ci sono anche gli utenti che già segui 
        - updateDataUtente non funziona
 -->



<head>
    <title>Twetter Copy Login</title>
    <link rel="stylesheet" href="../server/style/login.css">

</head>

<?php
session_start();
include("../server/functions.php");
// createHeader();
?>

<body>
    <div class="loginClass">
        <h1>LOGIN</h1>

        <div class="login-form">
            <form action="../client/login.php" method="post">
                <br>Username: <input type='text' name='username'><br>
                <br>Password: <input type='password' name='password'><br>
                <br><button name='login'>Login</button><br>

                <br>
                <hr><button name='createAccount'>Create Account</button><br>
            </form>
        </div>
    </div>
    <?php include_once("../server/footer.php"); ?>

</body>

<?php if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $resutl = getLogin($username, $password);
    if ($resutl == true) {
        header('Location: home.php');
        exit;
    } else {
        echo "<p class='errorLogin'> Login fallito <p>";
        exit;
    }

}

if (isset($_POST['createAccount'])) {
    echo "account ";
    header('Location: register.php');
    exit;
}
?>

</html>