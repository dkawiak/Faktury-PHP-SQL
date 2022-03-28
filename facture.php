<?php

	session_start();
	
	
	if(isset($_POST['nip']))
	{
		// udana walidacja? załóżmy że tak i sprawdzajmy czy na pewno
		$everything_OK=true;
		
		// sprawdzenie nip
		$nip = $_POST['nip'];
		//sprawdzenie długości nipu
		if((strlen($nip)<10) || (strlen($nip)>10))
		{
			$everything_OK=false;
			$_SESSION['e_nip']="Nip musi posiadać od 10 cyfr!";
		}

		//sprawdzenie czy nip składa się z samych cyfr
		if(is_numeric($nip)==false)
		{	
			$everything_OK=false;
			$_SESSION['e_nip']="NIP musi składać się tylko z 10 cyfr";
							
		}
		
		
		$nazwa = $_POST['nazwa'];

		
		
		//sprawdzenie czy kwota jest liczbą		
		$kwota = $_POST['kwota'];
		if(is_numeric($kwota)==false)
		{
			$everything_OK=false;
			$_SESSION['e_kwota']='Kwota musi być liczbą, przedzieloną . "kropką"';		
		}
		
		//sprawdź ilość miejsc po przecinku
		$kwota = (double)$kwota;
		if ((round($kwota, 2)< ($kwota)) || (round($kwota, 2)>($kwota)))
		{
			$everything_OK=false;
			$_SESSION['e_kwota']='Kwota musi być liczbą, przedzieloną . "kropką" do dwóch miejsc po przecinku';
		}
		
		
		$pozycja = $_POST['pozycja'];
		
	
	
		// sprawdzenie zaznaczenia checkboxa regulaminu
		if(!isset($_POST['regulamin']))
		{
			$everything_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu";	
		}
		
		$dataFaktury = date("Y-m-d");
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['fr_nip'] = $nip;
		$_SESSION['fr_nazwa'] = $nazwa;
		$_SESSION['fr_pozycja'] = $pozycja;
		$_SESSION['fr_kwota'] = $kwota;
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

				
				// jeżeli wszystko jest w porzatku, wpisz podane dane do bazy danych
				if($everything_OK==true)
				{
					if ($connection->query("INSERT INTO faktury VALUES (NULL, '$nazwa', '$nip', '$pozycja', '$kwota', '$dataFaktury' '')"))
					{
						$_SESSION['correctFacture']=true;
						header('Location: succes.php');
					}
					else
					{
						throw new Exception($connection->error);
					}
				}
				
				
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie</span>';
			echo '<br/>Informacja developerska: ' .$e;
		}


		
	}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<title>Wystaw fakturę</title>

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
<h1>Wystaw Fakturę </h1><br/><br/>


	<form method="post">
	
		NIP firmy: <input type="text" value="<?php
			if (isset($_SESSION['fr_nip']))
			{
				echo $_SESSION['fr_nip'];
				unset($_SESSION['fr_nip']);
			}
		?>" name="nip" /><br />
		
		<?php
			if (isset($_SESSION['e_nip']))
			{
				echo '<div class="error">'.$_SESSION['e_nip'].'</div>';
				unset($_SESSION['e_nip']);
			}
		?>
		
		<br/><br/>
		
		Nazwa firmy: <input type="text" value="<?php
			if (isset($_SESSION['fr_nazwa']))
			{
				echo $_SESSION['fr_nazwa'];
				unset($_SESSION['fr_nazwa']);
			}
		?>" name="nazwa" /><br />
		
		<?php
			if (isset($_SESSION['e_nazwa']))
			{
				echo '<div class="error">'.$_SESSION['e_nazwa'].'</div>';
				unset($_SESSION['e_nazwa']);
			}
		?>
		
		<br/><br/>
		
		Pozycja na fakturze: 
		<select name="pozycja" name="pozycja">
			<option value="Usługa">Usługa</option>
			<option value="Towar">Towar</option>
		</select>
		
		<?php
			if (isset($_SESSION['e_pozycja']))
			{
				echo '<div class="error">'.$_SESSION['e_pozycja'].'</div>';
				unset($_SESSION['e_pozycja']);
			}
		?>		
		
		<br/><br/>
		
		kwota: <input type="text" value="<?php
			if (isset($_SESSION['fr_kwota']))
			{
				echo $_SESSION['fr_kwota'];
				unset($_SESSION['fr_kwota']);
			}
		?>" name="kwota" /><br />
		
				<?php
			if (isset($_SESSION['e_kwota']))
			{
				echo '<div class="error">'.$_SESSION['e_kwota'].'</div>';
				unset($_SESSION['e_kwota']);
			}
		?>
		
		<br/><br/>
		
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
		?>	
		

		
		<br/><br/>
		
		<input type="submit" value="Wystaw fakturę" />
		
		<br/><br/>
		<a href="index.php">Powrót do strony głownej</a></br/><br/>
	
	
	
	</form>



	






</body>
</html>