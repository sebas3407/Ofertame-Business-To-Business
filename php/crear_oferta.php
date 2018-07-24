<?php
	header('Content-Type: text/html; charset=UTF-8');
	session_start();

	date_default_timezone_set('Europe/Madrid');
	$connect = mysqli_connect("localhost","root","usbw","test_proyecto");

	$nombre = $_POST["nombre"];
	$descripcion = $_POST["descripcion"];
	$unidades = $_POST["unidades"];
	$categoria = $_POST["categoria"];
	$fecha = $_POST["fecha"];
	$ruta = "../img/ofertas/";
	$nombre_empresa = $_SESSION["nombre_empresa"];
	$correo_empresa = $_SESSION["email_empresa"];

	$offer_date = date("Y-m-d");

	$sql = "SELECT ofertas_restantes FROM contrata WHERE correo_empresa = '$correo_empresa' and activo = 1";

	$result = mysqli_query($connect,$sql);

	$fila = mysqli_fetch_array($result,MYSQLI_BOTH);

	$ofertas_restantes = $fila[0];

	if ($ofertas_restantes != 0)
	{	
		$nombre_imagen = $_FILES['foto'] ['name'];
		$tipo_imagen = $_FILES['foto'] ['type'];
		$tamagno_imagen = $_FILES['foto'] ['size'];

		if ($tamagno_imagen <= 1000000)
		{
			if ($tipo_imagen  == 'image/jpeg' || $tipo_imagen  == 'image/jpg' || $tipo_imagen  == 'image/png')
			{	
				$ruta_provisional = $_FILES['foto'] ['tmp_name'];
				$dimensiones = getimagesize($ruta_provisional);
				$width = $dimensiones[0];
				$height = $dimensiones[1];

				if ($width == 700 && $height == 400)
				{
					$carpeta_destino = $_SERVER ['DOCUMENT_ROOT'] . '/img/ofertas/';

					move_uploaded_file($_FILES['foto'] ['tmp_name'], $carpeta_destino.$nombre_imagen);
					
					$ruta = $ruta . $nombre_imagen;

					$sql2 = "INSERT INTO OFERTA VALUES(null,'$nombre','$categoria','$nombre_empresa','$descripcion',$unidades,1,'$offer_date','$fecha','$ruta',1)";

					if (mysqli_query($connect,$sql2))
					{	
						$sql3 = "UPDATE contrata SET ofertas_restantes = ofertas_restantes - 1 where correo_empresa = '$correo_empresa' and activo = 1";

						if (mysqli_query($connect,$sql3))
						{	
							$_SESSION["ofertas_restantes"] = $_SESSION["ofertas_restantes"] - 1;

							if ($_SESSION["ofertas_restantes"] == 0)
							{
								$sql4 = "UPDATE contrata SET activo = 0 where correo_empresa = '$correo_empresa'";

								if (mysqli_query($connect,$sql4))
								{
									
								}
							}
							
							echo "3";
						}
					}
					else
					{
						echo "2";
					}
				}
				else
				{
					echo "6";
				}
			}
			else
			{
				echo "5";
				exit();
			}
		}
		else
		{
			echo "4";
			exit();
		}
	}
	else
	{
		echo "1";
	}

?>