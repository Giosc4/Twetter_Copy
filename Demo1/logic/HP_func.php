<?php
		session_start();

		if (isset($_SESSION['username'])) {
			// La sessione è stata avviata correttamente
			$username = $_SESSION['username'];
			echo "<h1>Welcome, $username!</h1>";
		} else {
			header('Location: login.php');
			exit;
		} 
        
        if (isset($_POST['logout'])) {
			session_destroy();
			header("Location: login.php");
			exit();
		}

		if (isset($_POST['home'])) {
			session_destroy();
			header("Location: home_page.php");
			exit();
		}
        
		if (isset($_POST['profile'])) {
			header("Location: profile.php");
			exit();
		}

        if (isset($_POST['salva'])) {
            $text = $_POST['text'];
            $username = $_SESSION['username'];
            include("db.php");
            // Crea query
            $sql = "INSERT INTO tweets (user_id, text) VALUES ( '$username', '$text')";

            // Esegui query
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
		
		?>

