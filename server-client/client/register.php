<!DOCTYPE html>
<html>

<head>
  <title>Registrazione utente</title>
</head>

<body>
  <h1>Registrazione utente</h1>
  <form method="post" action="register.php">

    <?php
    session_start();

    include_once('../server/functions.php');
    ?>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <label>First name:</label><br>
    <input type="text" name="first_name" required><br><br>

    <label>Last name:</label><br>
    <input type="text" name="last_name" required><br><br>

    <label>Bio:</label><br>
    <textarea name="bio"></textarea><br><br>

    <input type="submit" name='register' value="Registrati">
    <br><input type='submit' name='login' value='Login'><br>

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