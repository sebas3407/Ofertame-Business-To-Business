<?php
	
	date_default_timezone_set('Europe/Madrid');
	$connect = mysqli_connect("localhost","root","usbw","test_proyecto");

	$correo = $_POST["email"];
	$pass = $_POST["password"];
	$nombre = $_POST["nombre"];
	$telefono = $_POST["telefono"];
	$direccion = $_POST["direccion"];
	$suscripcion = $_POST["suscripcion"];

	$sql = "SELECT correo FROM empresa WHERE correo='$correo'";

	$result = mysqli_query($connect,$sql);

	$num_row = mysqli_num_rows($result);

	if ($num_row == "0")
	{	
		$pass_hash = hash("md5","$pass");				
		$register_date = date("Y-m-d");

		$sql3 = "INSERT INTO empresa (nombre,clave,telefono,direccion,correo,activo) VALUES('$nombre', '$pass_hash', '$telefono', '$direccion', '$correo',1)";

		if (mysqli_query($connect,$sql3))
		{	
			$sql4 = "SELECT n_ofertas FROM suscripcion WHERE nombre = '$suscripcion'";

			$result = mysqli_query($connect,$sql4);

			$fila = mysqli_fetch_array($result,MYSQLI_BOTH);

			$ofertas = $fila[0];

			if (mysqli_query($connect,$sql4))
			{	
				$endSubscription = date("Y-m-d");
				$date = new DateTime($endSubscription);
				$date->add(new DateInterval('P1M'));
				$date = $date->format('Y-m-d');

				$sql5 = "INSERT INTO contrata (correo_empresa,nombre_suscripcion,ofertas_restantes,inicio_contrato,fin_contrato,activo) VALUES ('$correo','$suscripcion',$ofertas,'$register_date','$date',1)";

				if (mysqli_query($connect,$sql5))
				{	
					echo "3";
					session_start();
					$_SESSION["email_empresa"] = $correo;
					$_SESSION["suscripcion"] = $suscripcion;
					$_SESSION["ofertas_restantes"] = $ofertas;
					$_SESSION["nombre_empresa"] = $nombre;
				}
			}
		}
	}
	else
	{
		echo "1";
	}

?>