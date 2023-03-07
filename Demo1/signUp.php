<!DOCTYPE html>
<html>

<head>
    <title>Registrazione</title>
</head>
<!-- id	email	username	password	first_name	last_name	bio	profile_picture -->

<body>
    <h1>Registrati</h1>
    <form action="signUp.php" method="post">
        
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="nome">Nome:</label><br>
        <input type="text" id="first_name" name="first_name"><br>

        <label for="cognome">Cognome:</label><br>
        <input type="text" id="last_name" name="last_name"><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="bio">Biografia:</label><br>
        <input type="text" id="bio" name="bio"><br>

        <br><input type="submit" name="Registrati" value="Registrati"><br>
        <!-- id	email	username	password	first_name	last_name	bio	profile_picture -->

        <?php
        include("db.php");
        

        if (isset($_POST['Registrati'])) {
        
            $username = $_POST['username'];
            $password = $_POST['password'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $bio = $_POST['bio'];

            // Controlla che i campi obbligatori siano stati compilati
            if (empty($username) || empty($password) || empty($email)) {
                echo "Username, password, and email are required fields.";
                exit;
            }

            // Crittografa la password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (email, username, password, first_name, last_name, bio) VALUES ('$email', '$username', '$password_hash', '$first_name', '$last_name', '$bio')";
            $result = mysqli_query($conn, $sql);

            if ($result == FALSE) {
                // controlla se l'errore è per duplicazione
                if ($conn->error == 1062) {
                    echo "Errore: L'account esiste già nel database.";
                } else {
                    echo "Errore nell'inserimento dell'account: " . $conn->error;
                }
            } else {
                echo "Account Registrato";
            }                     
        }
        ?>

        <br><button onclick="location.href='delete_users.php'">DELETE USERS</button><br>
        <br><button onclick="location.href='login.php'">Login</button><br>

    </form>
</body>

</html>