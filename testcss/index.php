<!DOCTYPE html>
<html>

<head>
  <title>Profilo Twitter</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div class="wrapper">
    <div class="profile-display">
      <h2>Dati utente</h2>
      <ul>
        <li><strong>Nome:</strong> Mario</li>
        <li><strong>Cognome:</strong> Rossi</li>
        <li><strong>Email:</strong> email@utente.com</li>
        <li><strong>Username:</strong> @username</li>
        <li><strong>Bio:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum libero quis
          quam ultricies, nec faucibus enim vestibulum.</li>
      </ul>
    </div>
    <div class="profile-edit">
      <h2>Modifica profilo</h2>
      <form>
        <label for="first_name">Nome:</label>
        <input type="text" id="first_name" name="first_name">
        <label for="last_name">Cognome:</label>
        <input type="text" id="last_name" name="last_name">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"></textarea>
        <input type="submit" value="Salva">
      </form>
    </div>
    <div class="tweets">
      <h2>Tweet</h2>
      <ul>
        <li>
          <h3>Titolo tweet</h3>
          <p>Testo tweet</p>
          <span>Data</span>
        </li>
        <li>
          <h3>Titolo tweet</h3>
          <p>Testo tweet</p>
          <span>Data</span>
        </li>
        <li>
          <h3>Titolo tweet</h3>
          <p>Testo tweet</p>
          <span>Data</span>
        </li>
      </ul>
    </div>
  </div>
</body>

</html>