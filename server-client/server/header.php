<head>
    <link rel="stylesheet" href="../server/style/header.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="../client/home.php">
                <img src="../server/img/OIP.jpeg" alt="Twitter Logo">
            </a>
        </div>
        <nav>
            <ul>
                <li><a href="../client/home.php">Home</a></li>
                <li><a href="../client/profile.php">Profile</a></li>
            </ul>
        </nav>
        <div class="profile">
            <form action="../server/header.php" method="post">
                <input type='submit' class="logout-btn" name='logout' value='Logout'>
            </form>
        </div>
        <?php if (isset($_POST['logout'])) {
            session_start();
            session_destroy();
            header('Location: ../client/login.php');
        } ?>
    </header>
</body>
<?php

?>