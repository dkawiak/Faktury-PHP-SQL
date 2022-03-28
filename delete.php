<?php

	session_start();
	
	// przeniesienie do strony głownej osoby, która nie jest zalogowana, a próbuje dostać się na tą stronę
	if(!isset($_SESSION['logged']))
	{
			header('Location: index.php');
			exit();
	}
		
		
		// kontrola wciśnięcia przycisku usuń na stronie z fakturami admin.php
		if(isset($_POST['delete']))
		{
			// założenie, że wszystko jest ok i przeprowadzenie testów wprowadzonych w formularzu danych (nr faktury)
			$everything_OK=true;
			
			// sprawdzenie wprowadzonego numeru faktury
			$del = $_POST['delete'];
			
			//sprawdzenie czy wprowadzono cyfrę, bo numery faktur są numeryczne
			if(is_numeric($del)==false)
			{
				$everything_OK=false;
				$_SESSION['e_delete']='<span style="color:red">Podany numer musi być numerem</span>';
				header('Location: admin.php');				
			}
			
			
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
							// sprawdzenie czy numer faktury istnieje w bazie
							$result = $connection->query("SELECT id FROM faktury WHERE id='$del'");
						
							if(!$result) throw new Exception($connection->error);
						
							$ile_faktur = $result->num_rows;
							
								if($ile_faktur==0)
								{
									$everything_OK=false;
									$_SESSION['e_delete']="Brak faktury o podanym numerze, podaj poprawny numer faktury do usunięcia";
									header('Location: admin.php');					
								}
						
						
						
							// jeżeli wszystko jest w porzatku, usuwamy podany rekord z bazy i przenosimy na stronę potwierdzającą
							if($everything_OK==true)
							{
									if ($connection->query("DELETE FROM faktury WHERE id='$del'"))
									{
										$_SESSION['correctDelete']=true;
										header('Location: deletecomplete.php');
									}
									else
									{
										throw new Exception($connection->error);
									}
							}
						
						//zamknięcie połączenia
						$connection->close();
					}	
			
			
				}	
				catch(Exception $e)
				{
					echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o zgłoszenie do administratora</span>';
					echo '<br/>Informacja developerska: ' .$e;
				}
		}	

?>