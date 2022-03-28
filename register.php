<?php

	session_start();
	
	//Kontrola wysłania formularza na stronie rejestracji
	if(isset($_POST['email']))
	{
		// założenie, że wszystko jest ok i przeprowadzenie testów wprowadzonych w formularzu danych
		$everything_OK=true;
		
		// sprawdzenie nick
		$nick = $_POST['nick'];
		//sprawdzenie długości nicka
		if((strlen($nick)<3) || (strlen($nick)>20))
		{
			$everything_OK=false;
			$_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków!";
		}

		
		//sprawdzenie czy nick ma tylko znaki alfanumeryczne
		if(ctype_alnum($nick)==false)
		{
			$everything_OK=false;
			$_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		
		//sprawdzenie poprawności adresu mailowego
		$email = $_POST['email'];
		$emailCheck = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailCheck, FILTER_VALIDATE_EMAIL)==false) || ($emailCheck!=$email))
		{
			$everything_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres email";
		}
		
		//sprawdzenie poprawności haseł
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		//sprawdzenie długości hasła. Bezpieczne hasło posiada od 5 do 20 znaków
		if ((strlen($haslo1)<5) || (strlen($haslo1)>20))
		{
			$everything_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 5 do 20 znaków";			
		}
		
		//sprawdzenie zgodności wprowadzonego hasła z powtórzonym hasłem dla uniknięcie błędów		
		if($haslo1!=$haslo2)
		{
			$everything_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne";			
		}
		
		// hashowanie haseł, czyli ukrywanie ich w bazie
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		
		// sprawdzenie zaznaczenia checkboxa regulaminu
		if(!isset($_POST['regulamin']))
		{
			$everything_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu";	
		}
		
		
		//Zapamiętaj wprowadzone dane, w celu wyświetlenia danych już wprowadzonych przez użytkownika
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		
		
		// połączenie z bazą danych
		require_once "connect.php";
		
		//funkcja blokująca raportowanie błędów, a rzucająca tylko wyjątki które my ustalamy
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		//sprawdzenie czy podany login lub mail istnieje w bazie
		try
		{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if ($connection->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				// sprawdzenie czy mail istnieje
				$result = $connection->query("SELECT id FROM administratorzy WHERE email='$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$ile_maili = $result->num_rows;
				if($ile_maili>0)
				{
					$everything_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e -mail";	
				}
				
				// sprawdzenie czy nick istnieje
				$result = $connection->query("SELECT id FROM administratorzy WHERE user='$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$ile_nick = $result->num_rows;
				if($ile_nick>0)
				{
					$everything_OK=false;
					$_SESSION['e_nick']="Istnieje już konto o takim nicku";	
				}
				
				// jeżeli wszystko jest w porzatku, rejestrujemy użytkownika i jego dane w bazie i przenosimy na stronę z komunikatem
				if($everything_OK==true)
				{
					if ($connection->query("INSERT INTO administratorzy VALUES (NULL, '$nick', '$haslo_hash', '$email')"))
					{
						$_SESSION['correctRegister']=true;
						header('Location: welcome.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				// zamknięcie połączenia z bazą
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie</span>';
			echo '<br/>Informacja developerska: ' .$e; // informacja produkcyjna, do zakomentowania przy udostępnieniu strony dla użytkowników
		}


		
	}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Wystawianie faktur - załóż konto</title>

<style>
	.error
	{
		color:red;
		margin-top: 10px
		margin-bottom: 10px;
	}

</style>

</head>

<body>
	
	<!-- Formularz jejestracji z obsługą błędów i zapamiętywaniem wprowadzaonych danych -->
	<form method="post">
	
		Nickname: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_nick']))
			{
				echo $_SESSION['fr_nick'];
				unset($_SESSION['fr_nick']);
			}
		?>" name="nick" /><br />
		
		<?php
			if (isset($_SESSION['e_nick']))
			{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
			}
		?>
		
		
		E-mail: <br /> <input type="text" value="<?php
			if (isset($_SESSION['fr_email']))
			{
				echo $_SESSION['fr_email'];
				unset($_SESSION['fr_email']);
			}
		?>" name="email" /><br />
		
		<?php
			if (isset($_SESSION['e_email']))
			{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		
		
		Twoje hasło: <br /> <input type="password"  value="<?php
			if (isset($_SESSION['fr_haslo1']))
			{
				echo $_SESSION['fr_haslo1'];
				unset($_SESSION['fr_haslo1']);
			}
		?>" name="haslo1" /><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		
		
		Powtórz hasło: <br /> <input type="password" value="<?php
			if (isset($_SESSION['fr_haslo2']))
			{
				echo $_SESSION['fr_haslo2'];
				unset($_SESSION['fr_haslo2']);
			}
		?>" name="haslo2" /><br />
		
		
		<label>
			<input type="checkbox" name="regulamin" <?php
			if (isset($_SESSION['fr_regulamin']))
			{
				echo "checked";
				unset($_SESSION['fr_regulamin']);
			}
				?>/> Akceptuję regulamin
		</label>
		
		<?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>	<br/><br/>
		
		
		<input type="submit" value="Zarejestruj się" />
	
	</form>
		
		<br/><br/>
		
		<!-- Linki powrotu do strony głównej w przypadku rezygnacji z rejestracji -->
		<a href="index.php">Powrót do strony głownej</a></br/><br/>
	
	
	




	






</body>
</html>