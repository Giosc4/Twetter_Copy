<!DOCTYPE html>
<html>

<head>
  <title>Profilo utente</title>
  <link rel="stylesheet" href="../server/styleProfile.css">
</head>

<body>

  <?php
  session_start();
  include("../server/functions.php");
  if (!isset($_SESSION['username'])) {
    // Redirect all'area di login se l'utente non è loggato
    header('Location: start.php');
    exit;
  }
  include("../server/header.php");

  ?>
  <div class="wrapper">
    <div class="profile-display">
      <div class="boxProfile">
        <?php
        $username = $_SESSION['username'];

        $resutl = getDataUtente($username);
        if ($resutl != true) {
          header('Location: login.php');
          exit;
        }

        ?>
      </div>
    </div>
    <div class="tweet-list">
      <section>
        <h2>I miei Tweets</h2>
        <?php getTweetsHomeMine($username); ?>
      </section>
    </div>
    <div class="profile-edit">
      <form action="profile.php" method="post">
        <label for="first_name">Nome:</label>
        <input type="text" id="first_name" name="first_name">
        <label for="last_name">Cognome:</label>
        <input type="text" id="last_name" name="last_name">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"></textarea>
        <input type="submit" name='save' value="Salva">

      </form>
    </div>
    <?php
    if (isset($_POST['save'])) {
      if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['bio'])) {
        $newFirst_name = $_POST['first_name'];
        $newLast_name = $_POST['last_name'];
        $newEmail = $_POST['email'];
        $newPassword = $_POST['password'];
        $newBio = $_POST['bio'];
        updateDataUtente($newFirst_name, $newLast_name, $newEmail, $username, $newPassword, $newBio);
      }
    }

    ?>

  </div>
  <?php include("../server/footer.php"); ?>

</body>

</html>