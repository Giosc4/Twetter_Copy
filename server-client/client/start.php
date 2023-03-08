
<!DOCTYPE html>
<html>

<head>
    <title>Titolo della pagina</title>
</head>

<body>
    <?php 
      session_start();
    include("../server/functions.php");
    createHeader(); 
    ?>
    <form action="../server/issets.php" method="post">
        <br>Username: <input type='text' name='username' required><br>
        <br>Password: <input type='password' name='password' required><br>
        <br><input type='submit' name='login'><br>
    </form>

    <?php footer()?>
    
</body>

</html>