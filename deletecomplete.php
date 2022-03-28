<?php

	session_start();
	// sytuacja w której ktoś próbuje wejść na tą stronę a nie jest albo zalogowany albo nie wypełnił formularza usuwania - przeniesienie na stronę główną
	if(!isset($_SESSION['correctDelete']))
	{
		header('Location: admin.php');
		exit();
	}
	else
	{
		unset($_SESSION['correctDelete']);
	}


	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['delete'])) unset($_SESSION['delete']);

	
	//Usuwanie błędów
	if (isset($_SESSION['e_delete'])) unset($_SESSION['e_delete']);


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Usunięto fakturę</title>
</head>

<body>
	
	<h1>Poprawnie usunięto Fakturę! </h1><br/><br/>
	
	<a href="admin.php">Powrót do faktur!</a>
	</br/><br/>

		
</body>
</html>