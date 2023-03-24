<!DOCTYPE html>
<html>

<head>
    <title>Nome del social network</title>
    <link rel="stylesheet" href="../server/styleHome.css">
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
        <section class="new-tweet">
            <form action="home.php" method="post">
                <h2>Benvenuto
                    <?php echo $username = $_SESSION['username']; ?>
                </h2>
                <section class="new-tweet">
                    <textarea placeholder="What's happening?" name="text"></textarea>
                    <button type="submit" name="salva">Tweet</button>
                </section>

                <section>
                    <h2>Newsfeed</h2>
                    <!-- Qui andranno i tweet degli account seguiti dall'utente -->
                    <?php getTweetsHomeNotMine($username); ?>
                </section>
                <section>
                    <h2>I miei Tweets</h2>
                    <?php getTweetsHomeMine($username); ?>
                    <br> <br>
                    <input type='submit' name='logout' value='Logout'>
                </section>
            </form>
        </section>
    </main>


    <?php
    if (isset($_POST['logout'])) {
        // gestisci il click sul pulsante Logout
        session_start();
        session_destroy();
        header('Location: ../client/login.php');
    }
    if (isset($_POST['salva'])) {

        $result = writeTweetHome($username, $_POST['text']);
        if ($result == true) {
            echo "registrazione avvenuta con successo";
        } else {
            exit();
        }
    }

    ?>

    <?php include("../server/footer.php"); ?>

</body>

</html>