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
	$ofertaid = $_POST["ofertaid"];
	$nombre_empresa = $_SESSION["nombre_empresa"];
	$correo_empresa = $_SESSION["email_empresa"];

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

					$sql = "UPDATE oferta SET nombre_oferta='$nombre',categoria_oferta='$categoria',descripcion='$descripcion',unidades=$unidades,fecha_final='$fecha',ruta_imagen='$ruta' WHERE id_oferta = $ofertaid";

					if (mysqli_query($connect,$sql))
					{	
						echo "3";
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


?>