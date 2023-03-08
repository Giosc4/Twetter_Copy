
<?php
        session_start();
        include './logic/db.php';

        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                if (password_verify($password, $row['password'])) {
                    $password =  $row['password'];
                    $_SESSION['username'] = $username;
                    header('Location: home_page.php');
                    exit();
                } else {
                    echo 'Password errata';
                }
            }

            echo 'Username o password errati';
        }

        mysqli_close($conn);
        ?>
