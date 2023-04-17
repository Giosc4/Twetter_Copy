<!DOCTYPE html>
<html>

<head>
  <title>Profilo utente</title>
  <link rel="stylesheet" href="../server/style/profile.css">
</head>

<body>

  <?php
  session_start();
  include_once("../server/functions.php");
  if (!isset($_SESSION['username'])) {
    // Redirect all'area di login se l'utente non è loggato
    header('Location: start.php');
    exit;
  }
  include_once("../server/header.php");
  ?>
  <div class="wrapper">
    <div class="editMyProfile">

      <ul style="list-style-type:none;">
        <li>
          <table>
            <tr>
              <td>
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
              </td>
              <td>
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
                  $newFirst_name = $_POST['first_name'];
                  $newLast_name = $_POST['last_name'];
                  $newEmail = $_POST['email'];
                  $newPassword = $_POST['password'];
                  $newBio = $_POST['bio'];
                  updateDataUtente($newFirst_name, $newLast_name, $newEmail, $username, $newPassword, $newBio);
                }

                ?>
              </td>
            </tr>
          </table>
        </li>
        <br>
        <li>
          <div class="tweet-list">
            <h2>I miei Tweets</h2>
            <?php getTweetsHomeMine($username); ?>
          </div>
        </li>

        <li>
          <table class="followers-table">
            <tr>
              <td>

                <!-- lista dei follower -->
                <h3>My Followers</h3>
                <?php
                $followers = getMyFollowers($username);
                foreach ($followers as $follower) {
                  echo '<span class="username">' . $follower['friend_id'] . '</span>';
                  echo '<button class="unFollow" name="unFollow" value="' . $follower['friend_id'] . '"> Unfollow</button> <hr>';
                }
                ?>
              </td>
              <td>

                <!-- lista dei followed -->
                <h3>My Following</h3>
                <?php
                $followed = getMyFollowing($username);
                foreach ($followed as $follow) {
                  echo '<span class="username">' . $follow['friend_id'] . '</span>';
                  echo '<button class="unFollow" name="unFollow" value="' . $follow['friend_id'] . '"> Unfollow</button> <hr>';
                }
                ?>
              </td>
            </tr>
          </table>

        </li>
        <br>
        <li>
          <form action="profile.php" method="post">
            <input type="submit" name="deleteAccount" class="deleteAccount" value="Delete account"
              onclick="return confirm('Are you sure you want to delete your account?')">

          </form>
        </li>

      </ul>
    </div>



  </div>
  <?php 
  include_once("../server/footer.php");

  if (isset($_POST['deleteAccount'])) {
    deleteAccount($username);
  }



  ?>

</body>

</html>