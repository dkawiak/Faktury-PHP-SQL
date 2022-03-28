<?php

	session_start();
	
	// sytuacja w której ktoś próbuje wejść na stronę bez wprowadzenia poprawnych danych w formularzu rejestracji przeniesie go do strony index
	if(!isset($_SESSION['correctRegister']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['correctRegister']);
	}


	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Wystawianie faktur - strona powitalna</title>
</head>

<body>
	<h1>Poprawnie zarejestrowano użytkownika. Możesz przejść do logowania </h1><br/><br/>
	
	<a href="index.php">Zaloguj się na swoje konto!</a>
	</br/><br/>

		
</body>
</html>