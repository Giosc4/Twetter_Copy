<head>
    <link rel="stylesheet" href="../server/style/header.css">
</head>

<body>
    <header>
        <!-- <h1>TITOLO DEL SOCIAL</h1> -->

        <div class="logo">
            <img src="../server/img/OIP.jpeg" alt="Twitter Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../client/home.php">Home</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="../client/profile.php">Profile</a></li>
            </ul>
        </nav>
        <div class="profile">
            <img id="imgLogo" src="../server/img/profile-pic.jpg" alt="Profile Picture" width="50" height="50">
            <!-- <p>Username</p> -->
            <form action="../server/header.php" method="post">
                <input type='submit' name='logout' value='Logout'>
            </form>
        </div>
        <?php if (isset($_POST['logout'])) {
            // gestisci il click sul pulsante Logout
            session_start();
            session_destroy();
            header('Location: ../client/login.php');
        } ?>
    </header>
</body>


<?php

?>