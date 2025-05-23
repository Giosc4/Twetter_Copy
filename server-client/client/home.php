<!DOCTYPE html>
<html>

<head>
    <title>Twitter Copy Home</title>
    <link rel="stylesheet" href="../server/style/home.css">
</head>

<body>
    <?php
    session_start();
    if (!$_SESSION['username']) {
        header('Location: login.php');
        exit;
    }
    include("../server/functions.php");

    include("../server/header.php");
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        header('Location: ../client/login.php');
    }
    ?>

    <main>
        <form action="home.php" method="post">
            <div class="container">
                <section class="searchBar">
                    <input type="text" name="textInput" placeholder="Search..." />
                    <button type="submit" class="search" name="search">Search</button>
                </section>
                <br>
                <?php
                if (isset($_POST['search'])) {
                    echo "<div class='searchResult'>";
                    echo "<h2>Search Results:</h2>";
                    $search = $_POST['textInput'];
                    if (strpos($search, '@') !== false) {
                        $search = str_replace('@', '', $search);
                        searchBar_user($search);
                    } else {
                        searchBar_tweets($search);
                    }
                    echo "</div>";
                }
                ?>
                <hr>
                <section class="new-tweet">
                    <h2>Welcome
                        <?php echo $username = $_SESSION['username']; ?>
                    </h2>
                    <div class="tweet-form">
                        <textarea placeholder="What's happening?" name="text"></textarea>
                        <button type="submit" name="tweet">Tweet</button>
                    </div>
                    <?php
                    if (isset($_POST['tweet'])) {
                        $result = writeTweetHome($username, $_POST['text']);
                        if ($result == true) {
                            header('Location: ../client/home.php');
                        } else {
                            exit();
                        }
                    }
                    ?>
                </section>
                <section>
                    <div class="tweet-list">
                        <h2>Newsfeed</h2>
                        <div class="listTweet">
                            <?php getTweetsHome($username);
                            if (isset($_POST['deleteTweet'])) {
                                $tweetId = $_POST['deleteTweet'];
                                deleteTweet($tweetId);
                            }
                            if(isset($_POST["profileUser"])) {
                                $profileUser = $_POST["profileUser"];
                                header("Location: ../client/profileF.php?user=$profileUser");
                            }
                            if (isset($_POST['likeTweet'])) {
                                $postId = $_POST['likeTweet'];
                                $user_id = $_SESSION['username'];
                                addLiketoTweet($user_id, $postId);
                                echo "like added";
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="user-list">
                        <h2>New Users</h2>
                        <?php getUserListHome($username);
                        if (isset($_POST['newFollow'])) {
                            $user_id = $_SESSION['username'];
                            $friend_user = $_POST['userSelected'];
                            addFriend($user_id, $friend_user);
                            header('Location: ../client/home.php');
                        }
                        ?>
                    </div>
                </section>
            </div>
        </form>
    </main>
    <?php include("../server/footer.php"); ?>
</body>

</html>