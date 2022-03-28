<?php

	session_start();
	
	// przeniesienie do strony logowania osoby, która nie jest zalogowana, a próbuje dostać się na tą stronę
	if(!isset($_SESSION['logged']))
	{
		header('Location: index.php');
		exit();
	}
	

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<style>
table, th, td {
    border: 1px solid black;
}

.error
	{
		color:red;
		margin-top: 10px
		margin-bottom: 10px;
	}
</style>
<title>Wystawianie faktur - strona administratora faktur</title>
</head>

<body>
	
		<?php
			
			// wyświetlenie powitania użytkownika i adresu mailowego
			echo "<p><b>Witaj ".$_SESSION['user'].'!   </b>[<a href="logout.php">Wyloguj się!</a>]</p>';
			echo "<p>E-mail ".$_SESSION['email']."!</p>";	
		?>
</br/><br/>
<h1>FAKTURY W BAZIE</h1>
<br/><br/>
	
	<!-- Przycisk usuwający podaną fakturę z obsługą błędów-->
    <form action="delete.php" method="post">
	
		<input type="text" name="delete" />
		<input type="submit" value="usuń podany nr faktury z bazy "/>
	
	</form>
		<?php
		if (isset($_SESSION['e_delete']))
				{
					echo '<div class="error">'.$_SESSION['e_delete'].'</div>';
					unset($_SESSION['e_delete']);
				}


		?>
		
	<br/>	

		<?php
			
			require_once "connect.php";

			// połączenie z bazą danych
			$conn = new mysqli($host, $db_user, $db_password, $db_name);
			
			// Check connection
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}


			// tworzenie tabeli z danych umieszczonych w bazie danych
			$sql = "SELECT id, nazwa, nip, pozycja, kwota, data FROM faktury";
			$result = $conn->query($sql);
				
				// utworzenie tabeli jeżeli są w niej dane
				if ($result->num_rows > 0) {
				echo "<table>
				<thead>
				<tr>
				<th>nr faktury</th>
				<th>Nazwa</th>
				<th>NIP</th>
				<th>pozycja</th>
				<th>kwota</th>
				<th>data</th>

				</tr>
				</thead>";
 
					 // wypisanie danych w liniach w tabeli
					  while($row = $result->fetch_assoc()) 
					  {
							echo 
							"<tr>
							
							<td>".$row["id"]."</td>	
							<td>".$row["nazwa"]."</td>
							<td>".$row["nip"]."</td>
							<td>".$row["pozycja"]."</td>
							<td>".$row["kwota"]."</td>
							<td>".$row["data"]."</td>
							
							</tr>";
						
					  }
					  echo "</table>";

					  }
					 else {
					  echo "0 results";
					}
					
			//zamknięcie połączenia z bazą
			$conn->close();

		?>

	
</body>
</html>