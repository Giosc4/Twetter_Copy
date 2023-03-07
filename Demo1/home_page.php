<!DOCTYPE html>
<html>

<head>
	<title>Nome del social network</title>
</head>

<body>
	<header>
		<h1>Nome del social network</h1>
		<nav>
			<form action="home_page.php" method="post">
				<style>
					ul li {
						display: inline-block;
						margin-right: 10px;
					}
				</style>
				<ul>
					<li><input type="submit" name="home" value="Home"></li>
					<li><input type="submit" name="profile" value="Profile"></li>
					<li><input type="submit" name="logout" value="Logout"></li>

				</ul>
			</form>
		</nav>
	</header>

	<main>
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
		include("db.php");

		$query = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($conn, $query);

		mysqli_close($conn);

		?>
		<section>
			<h2>Add Tweet</h2>
			<form action="home_page.php" method="post">
				<label for="text">Aggiungi un tweet:</label><br>
				<input type="text" id="text" name="text"><br>
				<input type="submit" name="salva" value="Salva">
			</form>
			<?php
			include("db.php");
			if (isset($_POST['salva'])) {
				$text = $_POST['text'];
				$username = $_SESSION['username'];

				// Crea query
				$sql = "INSERT INTO tweets (user_id, text) VALUES ( '$username', '$text')";

				// Esegui query
				if ($conn->query($sql) === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}

			}

			// Imposta i parametri
			

			$conn->close();
			?>
		</section>

		<section>
			<h2>Newsfeed</h2>
			<!-- Qui andranno i tweet degli account seguiti dall'utente -->
			<?php
			include("db.php");

			$sql = "SELECT * FROM tweets, users WHERE user_id = username";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					if ($row["username"] != $_SESSION["username"]) {
						echo "<div style='border: 1px solid black; padding: 10px; width: 500px;'>";
						echo "Username: " . $row["username"] . "<br>Text: " . $row["text"] . "<br>Created At: " . $row["created_at"] . "<br>";
						echo "</div>";
					}
				}
			} else {
				echo "0 results";
			}
			?>
		</section>
		<section>
			<h2>Suggerimenti per nuovi account da seguire</h2>
			<H3>DA COMPLETARE</H3>
			<!-- Qui andranno i suggerimenti per nuovi account  DA COMPLETARE-->
		</section>

	</main>

	<footer>
		<p>&copy; Anno - Nome del social network</p>

	</footer>
</body>

</html>