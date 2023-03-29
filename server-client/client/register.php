<!DOCTYPE html>
<html>

<head>
  <title>Registrazione utente</title>
  <link rel="stylesheet" href="../server/register.css">
</head>

<body>
  <h1>Registrazione utente</h1>
  <form method="post" action="register.php">

    <?php
    session_start();

    include_once('../server/functions.php');
    ?>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Username:</label>
    <input type="text" name="username" required>

    <label>Password:</label>
    <input type="password" name="password" required>

    <label>First name:</label>
    <input type="text" name="first_name" required>

    <label>Last name:</label>
    <input type="text" name="last_name" required>

    <label>Bio:</label>
    <textarea name="bio"></textarea>

    <input type="submit" name='register' value="Registrati"> <br> <hr>
    <input type='submit' name='login' value='Login'>

    <?php
    if (isset($_POST['register'])) {


      // Recupero i dati dal form
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $bio = $_POST['bio'];

      $result = registerAccount($email, $username, $password, $first_name, $last_name, $bio);

      if ($result == true) {
        echo "registrazione avvenuta con successo";
      } else {
        exit();
      }
    }


    if (isset($_POST['login'])) {
      header('Location: ../client/login.php');
      exit();
    }
    ?>


  </form>
</body>

</html>