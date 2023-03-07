<!DOCTYPE html>
<html>

<head>
  <title>Profilo utente</title>
</head>

<body>
  <?php

  session_start();

  if (isset($_SESSION['username'])) {
    // La sessione è stata avviata correttamente
    $username = $_SESSION['username'];
  } else {
    header('Location: login.php');
    exit;
  }
  ?>
  <h1>Profilo utente:</h1>
  <?php echo "<h2>$username</h2>"; ?>

  <h3>Modifica i tuoi dati</h3>
  <form action="profile.php" method="post">
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

    <?php
    include("db.php");
    if (isset($_POST["change"])) {
      $old_username = $_SESSION['username'];

      $new_username = $_POST['username'];
      $new_password = $_POST['password'];
      $new_first_name = $_POST['first_name'];
      $new_last_name = $_POST['last_name'];
      $new_email = $_POST['email'];
      $new_bio = $_POST['bio'];

      // Controlla che i campi obbligatori siano stati compilati
      if (empty($new_username) || empty($new_password) || empty($new_email)) {
        echo "Username, password, and email are required fields.";
        exit;
      }

      // Crittografa la password
      $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

      // query di aggiornamento
      $queryUpdate = "UPDATE users SET username = '$new_username', password = '$password_hash', first_name = '$new_first_name', last_name = '$new_last_name', email = '$new_email', bio = '$new_bio' WHERE username = $old_username";
      $result = $conn->query($queryUpdate);

      if ($result) {
        echo "Dati aggiornati con successo";
        session_destroy();
        header('Location: login.php');

      } else {
        echo "Errore durante l'aggiornamento dei dati: " . $conn->error;
      }
    }
    ?>

  </form>
  <h3>I tuoi tweets</h3>
  <?php
			include("db.php");

			$sql = "SELECT * FROM tweets, users WHERE user_id = username";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					if($row["username"] == $_SESSION["username"]) {
					echo "<div style='border: 1px solid black; padding: 10px; width: 500px;'>";
					echo "Username: " . $row["username"] . "<br>Text: " . $row["text"] . "<br>Created At: " . $row["created_at"] . "<br>";
					echo "</div>";				
				}
				}
			} else {
				echo "0 results";
			}
			?>
  <br><button onclick="location.href='home_page.php'">Home Page</button>

</body>

</html>