<?php

	session_start();
	// jeśli ktoś chce wejść na stronę login a nie jest zalogowany i nie podał nic w formularzu to zostanie przeniesiony do strony głownej index.php
	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

	
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	//połączenie z bazą
	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			$login=$_POST['login'];
			$haslo=$_POST['haslo'];	
			
			// zabezpieczenie przed wstrzykiwaniem sql. Kontrola wprowadzanych danych w formularzu
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
			
			
			// wysłanie zapytania do bazy
			if ($result = @$connection->query(
			sprintf("SELECT * FROM administratorzy WHERE user='%s'",
			mysqli_real_escape_string($connection,$login))))
			{
				$ilu_userow = $result->num_rows;
				if($ilu_userow>0)
				{
					$wiersz = $result->fetch_assoc();
					
					if (password_verify($haslo, $wiersz['pass']))
					{
					
						// określenie zmiennej, że sesja jest zalogowana
						$_SESSION['logged'] = true;
						
						
						$_SESSION['id'] = $wiersz['id'];
						$_SESSION['user'] = $wiersz['user'];
						$_SESSION['email'] = $wiersz['email'];
						
						unset($_SESSION['blad']);			
		
						$result->close();
						// po zalogowaniu przeniesienie do strony admin.php
						header('Location: admin.php');
					}
					else
					{
						// błędny login lub hasło w formularzu
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
						header('Location: index.php');
					}
					
					
				}
				else
				{
					// błędny login lub hasło w formularzu
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
					header('Location: index.php');
				}
			}
				else
				{
					throw new Exception($polaczenie->error);
				}
				
				$connection->close();
		}
			
			
			
		
	}
	catch(Exception $e)
	{
		echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o wizytę w innym terminie!</span>';
		echo '<br />Informacja developerska: '.$e;
	}


	
?>