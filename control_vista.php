<?php
	header("Content-Type: text/html;charset=utf-8");
	include_once("model.php");
	
	if (isset($_POST["opcio"]))
	{
		$opcio = $_POST["opcio"];
		switch ($opcio)
		{
			case "login":
				include_once("login.html");
				break;
			
			case "register":
				include_once("register.html");
				break;
			
			case "land_airplane":
				include_once("land_airplane.html");
				break;
			
			case "takeOff_airplane":
				include_once("takeoff_airplane.html");
				break;

			case "airplane_flying":
				include_once("airplane_flying.html");
				break;

			case "airplane_in_airport":
				include_once("airplane_in_airport.html");
				break;

			case "import_airplane":
				include_once("import_airplanes.html");
				break;
		
		}
	}


	function show_error ($error_code)
	{
		switch ($error_code)
		{
			case -1:
				$texte = "Error en la instruccio SQL";
			break;
			case -2:
				$texte = "Airplane already added";
			break;
			case -3:
				$texte = "No s'ha pogut realitzar la connexió";
			break;
			case -4:
				$texte = "Missing Airplane";
			break;
			case -5:
				$texte = "Missing airport";
			break;
			case -6:
				$texte = "Invalid option";
			break;
			case -1:
				$texte = "Error en la instruccio SQL";
			break;
			case -1:
				$texte = "Error en la instruccio SQL";
			break;
			default: $texte = $error_code;
		}
		
		echo ("<br><color = red><h2>$texte</h2></color>");
	}
	
	function show_message ($message)
	{
		echo ("<br><color = green><h2>$message</h2></color>");
	}
?>