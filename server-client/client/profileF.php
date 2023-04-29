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
    $user_id = $_SESSION['username'];

    if (!isset($_GET['user'])) {
        exit;
    }
    $profileUser = $_GET['user'];

    include_once("../server/header.php");
    ?>
    <div class="wrapper">
        <div class="editMyProfile">
            <ul style="list-style-type:none;">
                <li>
                    <h1>USER:
                        <?php echo $profileUser; ?>
                    </h1>
                </li>
                <br>
                <li>
                    <div class="tweet-list">
                        <h2>Tweets</h2>

                        <?php

                        getMyTweets($profileUser);
                        if (isset($_POST['deleteTweet'])) {
                            $tweetId = $_POST['deleteTweet'];
                            deleteTweet($tweetId);
                        }
                        if (isset($_POST['likeTweet'])) {
                            $postId = $_POST['likeTweet'];
                            addLiketoTweet($user_id, $postId);
                        }
                        ?>
                    </div>
                </li>

                <li>
                    <form action="profileIsset.php" method="post">
                        <?php

                        if (isFollowed($user_id, $profileUser)) {
                            echo "<button class='follow-button' value='$profileUser' name='unFollow' type='submit'>Unfollow</button>";
                        } else {
                            echo "<button class='follow-button'value='$profileUser' name='newFollow' type='submit'>Follow</button>";
                        }

                        ?>

                    </form>

                </li>

                <li>
                    <p class='countFollow'>User Followed:
                        <?php echo count(getMyFollowers($profileUser)); ?>
                        User Following:
                        <?php echo count(getMyFollowing($profileUser)); ?>
                    </p>

                </li>
            </ul>
        </div>
    </div>
    <?php
    include_once("../server/footer.php");
    ?>
</body>

</html>