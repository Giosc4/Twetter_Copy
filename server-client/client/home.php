<!DOCTYPE html>
<html>

<head>
    <title>Nome del social network</title>
    <link rel="stylesheet" href="../server/style/home.css">
</head>

<body>
    <?php
    session_start();
    if (!$_SESSION['username']) {
        // Redirect all'area di login se l'utente non è loggato
        header('Location: login.php');
        exit;
    }


    include("../server/functions.php");

    include("../server/header.php");

    ?>
    <main>
        <div class="container">

            <section class="new-tweet">
                <form action="home.php" method="post">
                    <h2>Benvenuto
                        <?php echo $username = $_SESSION['username']; ?>
                    </h2>
                    <div class="tweet-form">
                        <textarea placeholder="What's happening?" name="text"></textarea>
                        <button type="submit" name="tweet">Tweet</button>
                    </div>
                </form>
            </section>

            <section>
                <div class="tweet-list">
                    <h2>Newsfeed</h2>
                    <div class="listTweet">
                        <?php getTweetsHomeNotMine($username); ?>
                    </div>
                </div>
            </section>

            <section>
                <div class="tweet-list">
                    <h2>my Tweets</h2>
                    <div class="listTweet">
                        <?php getTweetsHomeMine($username); ?>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <?php include("../server/footer.php"); ?>


    <?php
    if (isset($_POST['logout'])) {
        // gestisci il click sul pulsante Logout
        session_start();
        session_destroy();
        header('Location: ../client/login.php');
    }
    if (isset($_POST['tweet'])) {

        $result = writeTweetHome($username, $_POST['text']);
        if ($result == true) {

            header('Location: ../client/home.php');
        } else {
            exit();
        }
    }

    include("../server/db.php");

    if (isset($_POST['deleteTweet'])) {
        $tweetId = $_POST['deleteTweet'];
        $sql = "DELETE FROM tweets WHERE tweet_id = '$tweetId'";
        $result = $conn->query($sql);
        if ($result) {
            header('Location: ../client/home.php');
        } else {
            echo "ERRORE: durante l'eliminazione del tweet";
        }
    }

    ?>



</body>

</html>