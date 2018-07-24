<?php
	
	session_start();
	date_default_timezone_set('Europe/Madrid');
	$connect = mysqli_connect("localhost","root","usbw","test_proyecto");

	$suscripcion = $_POST["suscripcion"];
	$correo_empresa = $_SESSION["email_empresa"];

	$today_date = date("Y-m-d");

	//$sql = "SELECT ofertas_restantes FROM contrata where correo_empresa = '$correo_empresa' and curdate() < fin_contrato";

	$sql = "SELECT * FROM contrata where correo_empresa = '$correo_empresa' and curdate() < fin_contrato and ofertas_restantes > 0 and activo = 1";

	$result = mysqli_query($connect,$sql);

	$fila = mysqli_fetch_array($result,MYSQLI_BOTH);

	$inf = $fila[0];

	echo $fila[0];

	if (is_null($inf))
	{	
		$sql2 = "SELECT n_ofertas FROM suscripcion WHERE nombre = '$suscripcion'";

		$result = mysqli_query($connect,$sql2);

		$fila = mysqli_fetch_array($result,MYSQLI_BOTH);

		$ofertas = $fila[0];

		$endSubscription = date("Y-m-d");
		$date = new DateTime($endSubscription);
		$date->add(new DateInterval('P1M'));
		$date = $date->format('Y-m-d');

		$sql3 = "INSERT INTO contrata VALUES ('$correo_empresa','$suscripcion',null,$ofertas,'$today_date','$date',1)";

		if (mysqli_query($connect,$sql3))
		{	
			$_SESSION["suscripcion"] = $suscripcion;
			$_SESSION["ofertas_restantes"] = $ofertas;
			echo "3";
		}
		else
		{
			echo "jope";
		}
	}
	else
	{
		echo "1";
	}

?>