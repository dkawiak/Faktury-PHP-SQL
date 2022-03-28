<?php

	session_start();
	
	// sytuacja w której jest ktoś zalogowany wejście na index przeniesie go do strony admin dla zalogowanego
	if((isset($_SESSION['logged'])) && ($_SESSION['logged']==true))
	{
		header('Location: admin.php');
		exit();
	}
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Wystawianie faktur, logowanie i rejestracja</title>
</head>

<body>
	
	
	<h2>Logowanie do panelu administratora faktur<h2>
	
	<!-- Formularz logowania z obługą błędnych danych -->
	<form action="login.php" method="post">
	
		Login:<br/><input type="text" name="login"/><br/>
		Hasło:<br/><input type="password" name="haslo"/><br/>
		
			<?php
				if(isset($_SESSION['blad']))		
					echo $_SESSION['blad'];
					unset($_SESSION['blad']);


			?> <br/><br/>
		
		<input type="submit" value="Zaloguj się"/>
	
	</form>
	
	
	
	<!-- Linki do rejestracji i do wystawiania faktur -->
	<br/>
	<a href="register.php">Rejestracja - załóż darmowe konto administratora!</a></br/><br/>
	
	<br/>
	<a href="facture.php">Wystaw fakturę!</a></br/><br/>


</body>
</html>