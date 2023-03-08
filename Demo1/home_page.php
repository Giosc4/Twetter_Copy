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

		<section>
			<h2>Add Tweet</h2>
			<form action="./logic/HP_func.php" method="post">
				<?php include "./logic/HP_func.php"; ?>
				<label for="text">Aggiungi un tweet:</label><br>
				<input type="text" id="text" name="text"><br>
				<input type="submit" name="salva" value="Salva">


			</form>

		</section>

		<section>
			<h2>Newsfeed</h2>
			<!-- Qui andranno i tweet degli account seguiti dall'utente -->
			<?php include("./logic/newsFeed.php") ?>
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