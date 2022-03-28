<?php

	session_start();
	// sytuacja w której jest ktoś zalogowany wejście na index przeniesie go do strony admin dla zalogowanego
	if(!isset($_SESSION['correctFacture']))
	{
		header('Location: index.php');
		exit();
	}
	else
	{
		unset($_SESSION['correctFacture']);
	}


	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_nip'])) unset($_SESSION['fr_nip']);
	if (isset($_SESSION['fr_nazwa'])) unset($_SESSION['fr_nazwa']);
	if (isset($_SESSION['fr_pozycja'])) unset($_SESSION['fr_pozycja']);
	if (isset($_SESSION['fr_kwota'])) unset($_SESSION['fr_kwota']);
	if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_nip'])) unset($_SESSION['e_nip']);
	if (isset($_SESSION['e_nazwa'])) unset($_SESSION['e_nazwa']);
	if (isset($_SESSION['e_pozycja'])) unset($_SESSION['e_pozycja']);
	if (isset($_SESSION['e_pozycja'])) unset($_SESSION['e_pozycja']);
	if (isset($_SESSION['e_kwota'])) unset($_SESSION['e_kwota']);

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Wystawianie faktur</title>
</head>

<body>
	<h1>Faktura zapisana w systemie.</h1><br/><br/>
	
	<a href="index.php">Powrót do strony głównej</a>
	</br/><br/>
	
	<a href="facture.php">Wystaw następną fakturę</a>
	</br/><br/>

		
</body>
</html>