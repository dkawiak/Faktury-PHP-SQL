<?php

	session_start();
	
	session_unset();
	
	// wylogowanie i powrót do strony głownej
	header('Location: index.php');


?>

