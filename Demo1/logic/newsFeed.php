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