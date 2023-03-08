<!DOCTYPE html>
<html>

<head>
    <title>Nome del social network</title>
</head>

<body>
    <?php
      session_start();
    include("../server/functions.php");
    createHeader();
    ?>

    <section>
        <h2>Add Tweet</h2>
        <form action="issets.php" method="post">
            <label for="text">Write something:</label><br>
            <input type="text" id="text" name="text"><br>
            <input type="submit" name="salva" value="Salva">

        </form>

    </section>

    <section>
        <h2>Newsfeed</h2>
        <!-- Qui andranno i tweet degli account seguiti dall'utente -->
        <?php 
        getTweetsHome(); ?>
    </section>
    <section>
        <h2>Suggerimenti per nuovi account da seguire</h2>
        <H3>DA COMPLETARE</H3>
        <!-- Qui andranno i suggerimenti per nuovi account  DA COMPLETARE-->
    </section>


    <?php footer() ?>

</body>

</html>