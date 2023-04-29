<!DOCTYPE html>
<html>

<head>
  <title>Twitter Copy Profile</title>
  <link rel="stylesheet" href="../server/style/profile.css">
</head>

<body>
  <?php
  session_start();
  include_once("../server/functions.php");
  if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
  }
  include_once("../server/header.php");
  ?>
  <div class="wrapper">
    <div class="editMyProfile">
      <ul style="list-style-type:none;">
        <li>
          <h1>USER:
            <?php echo $_SESSION['username']; ?>
          </h1>
        </li>
        <li>
          <table>
            <tr>
              <td>
                <div class="profile-display">
                  <div class="boxProfile">
                    <?php
                    $username = $_SESSION['username'];
                    $results = getUserData($username);
                    if ($results != true) {
                      header('Location: login.php');
                      exit;
                    }
                    ?>
                  </div>
                </div>
              </td>
              <td>
                <div class="profile-edit">
                  <form action="myProfile.php" method="post">
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
                    <input type="submit" name='save' value="Save">
                  </form>
                </div>
                <?php
                if (isset($_POST['save'])) {
                  $newFirst_name = $_POST['first_name'];
                  $newLast_name = $_POST['last_name'];
                  $newEmail = $_POST['email'];
                  $pass = $_POST['password'];
                  $newBio = $_POST['bio'];

                  if (empty($newFirst_name) && empty($newLast_name) && empty($newEmail) && empty($newBio) && empty($pass)) {
                    echo "Please fill in all fields";
                  } else {
                    if (!empty($pass)) {
                      $hashPassword = password_hash($pass, PASSWORD_DEFAULT);
                    } else {
                      $hashPassword = "";
                    }
                    updateUserData($newFirst_name, $newLast_name, $newEmail, $username, $hashPassword, $newBio);
                  }
                }
                ?>
              </td>
            </tr>
          </table>
        </li>
        <br>
        <li>
          <div class="tweet-list">
            <h2>My Tweets</h2>
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
          <form action="myProfile.php" method="post">
            <table class="followers-table">
              <tr>
                <td>
                  <?php $followers = getMyFollowers($username); ?>
                  <h3>Follow Me:
                    <?php echo count($followers); ?>
                  </h3>
                  <?php
                  foreach ($followers as $follow) {
                    // echo '<span class="username">' . $follow['username'] . '</span>';
                    echo "User: <button class='userButton' type='submit' name='profileUser' value='" . $follow["follower_username"] . ">" . $follow["follower_username"] . "</button>";
                    echo '<button class="unFollow" name="unFollowMe" value="' . $follow['username'] . '"> Unfollow</button> <hr>';
                  }

                  ?>
                </td>
                <td>
                  <?php $followed = getMyFollowing($username); ?>
                  <h3>I Follow:
                    <?php echo count($followed); ?>
                  </h3>
                  <?php
                  foreach ($followed as $follow) {
                    // echo '<span class="username">' . $follow['follower_username'] . '</span>';
                    echo "User: <button class='userButton' type='submit' name='profileUser' value='" . $follow["follower_username"] . "' class='buttonUser'>" . $follow["follower_username"] . "</button>";
                    echo '<button class="unFollow" name="IunFollow" value="' . $follow['follower_username'] . '"> Unfollow</button> <hr>';
                  }
                  ?>
                </td>
              </tr>
            </table>
          </form>
          <?php
          if (isset($_POST['IunFollow'])) {
            $unFollow = $_POST['IunFollow'];
            removeFriend($username, $unFollow);
            header('Location: ../client/myProfile.php');
          }
          if (isset($_POST['unFollowMe'])) {
            $unFollow = $_POST['unFollowMe'];
            removeFriend($unFollow, $username);
            header('Location: ../client/myProfile.php');
          }
          if (isset($_POST["profileUser"])) {
            $profileUser = $_POST["profileUser"];
            header("Location: ../client/profileF.php?user=$profileUser");
          }
          ?>
        </li>
        <br>
        <li>
          <form action="myProfile.php" method="post">
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