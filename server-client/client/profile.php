<!DOCTYPE html>
<html>

<head>
  <title>Twetter Copy Profile</title>
  <link rel="stylesheet" href="../server/style/profile.css">
</head>

<body>

  <?php
  session_start();
  include_once("../server/functions.php");
  if (!isset($_SESSION['username'])) {
    // Redirect all'area di login se l'utente non è loggato
    header('Location: login.php');
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
                    <label>Name:</label>
                    <input type="text" id="first_name" name="first_name">
                    <label>Surname:</label>
                    <input type="text" id="last_name" name="last_name">
                    <label>Email:</label>
                    <input type="email" id="email" name="email">
                    <label>Password:</label>
                    <input type="password" id="password" name="password">
                    <label>Bio:</label>
                    <textarea id="bio" name="bio"></textarea>
                    <input type="submit" name='save' value="Salva">

                  </form>
                </div>
                <?php
                if (isset($_POST['save'])) {
                  echo $newFirst_name = $_POST['first_name'];
                  echo $newLast_name = $_POST['last_name'];
                  echo $newEmail = $_POST['email'];
                  echo $newPassword = $_POST['password'];
                  echo $newBio = $_POST['bio'];
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
            <?php getMyTweets($username);
            if (isset($_POST['deleteTweet'])) {
              $tweetId = $_POST['deleteTweet'];
              deleteTweet($tweetId);
            }
            if (isset($_POST['likeTweet'])) {
              $postId = $_POST['likeTweet'];
              $user_id = $_SESSION['username'];
              addLiketoTweet($user_id, $postId);
            }
            ?>
          </div>
        </li>

        <li>
          <form action="profile.php" method="post">
            <table class="followers-table">
              <tr>
                <td>
                  <?php $followers = getMyFollowers($username); ?>
                  <!-- lista dei follower -->
                  <h3>I Follow :
                    <?php echo count($followers); ?>
                  </h3>
                  <?php
                  foreach ($followers as $follow) {
                    echo '<span class="username">' . $follow['username'] . '</span>';
                    echo '<button class="unFollow" name="unFollow" value="' . $follow['username'] . '"> Unfollow</button> <hr>';
                  }

                  ?>
                </td>
                <td>
                  <?php $followed = getMyFollowing($username); ?>

                  <!-- lista dei followed   -->
                  <h3>Follows Me:
                    <?php echo count($followed); ?>
                  </h3>
                  <?php
                  foreach ($followed as $follow) {
                    echo '<span class="username">' . $follow['follower_username'] . '</span>';
                    echo '<button class="unFollow" name="unFollow" value="' . $follow['follower_username'] . '"> Unfollow</button> <hr>';
                  }
                  ?>

                </td>
              </tr>

            </table>


          </form>
          <?php
          
          if (isset($_POST['unFollow'])) {
            $unFollow = $_POST['unFollow'];
            removeFriend($username, $unFollow);
            header("Refresh:0");

          }

          ?>

        </li>
        <br>
        <li>
          <form action="profile.php" method="post">
            <input type="submit" name="deleteAccount" class="deleteAccount" value="Delete account"
              onclick="return confirm('Are you sure you want to delete your account?')">

            <?php
            if (isset($_POST['deleteAccount'])) {
              deleteAccount($username);
            }
            ?>
          </form>
        </li>

      </ul>
    </div>
  </div>
  <?php
  include_once("../server/footer.php");

  ?>

</body>

</html>