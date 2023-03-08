<?php
function createHeader()
{
    $title = "
    <h1>My App for Tweets</h1>
    <h2This is my social media like Twetter </h2>";
    $bar = "
    <div style='display: inline-block; margin-right: 50px;'>
    <form action='../server/issets.php' method='post'>
    <input type='submit' name='home' value='Home'>
    <input type='submit' name='profile' value='Profile'>
    <input type='submit' name='logout' value='Logout'>
    </form>
    </div>
    ";
    echo $title;
    echo $bar;
}

function footer(){
    echo "<footer>";
	echo "<p>&copy; 2023 - Giovanni Maria Savoca</p>";
	echo "</footer>";
}


function getTweetsHome()
{
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
}

function getTweetsProfile(){
    include("db.php");

    $sql = "SELECT * FROM tweets, users WHERE user_id = username";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					if($row["username"] == $_SESSION["username"]) {
					echo "<div style='border: 1px solid black; padding: 10px; width: 500px;'>";
					echo "Username: " . $row["username"] . "<br>Text: " . $row["text"] . "<br>Created At: " . $row["created_at"] . "<br>";
					echo "</div>";				
				}
				}
			} else {
				echo "0 results";
			}
}



?>