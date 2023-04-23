<!DOCTYPE html>
<html>

<head>
  <title>Twetter Copy Register</title>
  <link rel="stylesheet" href="../server/style/register.css">
</head>

<body>
  <h1>Registrazione utente</h1>
  <form method="post" action="register.php">

    <?php
    session_start();

    include('../server/functions.php');
    ?>

    <div class="registerDiv">

      <label>Email:</label>
      <input type="email" name="email">

      <label>Username:</label>
      <input type="text" name="username">

      <label>Password:</label>
      <input type="password" name="password">

      <label>First name:</label>
      <input type="text" name="first_name">

      <label>Last name:</label>
      <input type="text" name="last_name">

      <label>Bio:</label>
      <input type="text" name="bio"> <br>

      <br><button name='register'> Registrati</button>

      <hr>

    </div>
    <button name='login'> Login</button>

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