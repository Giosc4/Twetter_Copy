<!DOCTYPE html>
<html>

<head>
  <title>Profilo utente</title>
</head>

<body>

  <?php
  session_start();
  include("../server/functions.php");
  createHeader();
  ?>

  <h1>Profilo utente:</h1>
  <?php echo "<h2> " . $_SESSION['username'] . "</h2>"; ?>

  <h3>Modifica i tuoi dati</h3>

  <form action="../server/profileCheck.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>

    <label for="nome">Nome:</label><br>
    <input type="text" id="first_name" name="first_name"><br>

    <label for="cognome">Cognome:</label><br>
    <input type="text" id="last_name" name="last_name"><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>

    <label for="bio">Biografia:</label><br>
    <input type="text" id="bio" name="bio"><br>

    <br><input type="submit" name="change" value="Change"><br>



  </form>
  <h3>I tuoi tweets</h3>
  <?php getTweetsProfile(); ?>

  <?php footer() ?>
</body>

</html>