<?php

	$connect = mysqli_connect("localhost","root","usbw","test_proyecto");

	if(isset($_POST["email"]) && isset($_POST["password"]))
	{

		$correo = $_POST["email"];
		$pass = $_POST["password"];

		$pass_hash = hash("md5","$pass");

		if($correo == 'admin@admin.com')
		{
			
			$sql = "SELECT count(*) from empresa where correo = '$correo' and clave = '$pass_hash'";

			$result = mysqli_query($connect,$sql);

			$num_row = mysqli_num_rows($result);

			if($num_row == "1")
			{
				session_start();
				echo "2";
			}
		}
		else
		{

			$sql = "SELECT correo,clave,nombre from empresa WHERE activo = 1 AND correo='$correo' AND clave='$pass_hash'";

			$result = mysqli_query($connect,$sql);
			$num_row = mysqli_num_rows($result);


			if($num_row == "1")
			{	
				$sql2 = "SELECT nombre_suscripcion,ofertas_restantes from contrata where correo_empresa = '$correo' AND activo = 1";
				$result2 = mysqli_query($connect,$sql2);
				$num_row = mysqli_num_rows($result2);

				if($num_row == "1")
				{	
					session_start();
					$data = mysqli_fetch_array($result);
					$data2 = mysqli_fetch_array($result2);
					$_SESSION["email_empresa"] = $data["correo"];
					$_SESSION["suscripcion"] = $data2["nombre_suscripcion"];
					$_SESSION["ofertas_restantes"] = $data2["ofertas_restantes"];
					$_SESSION["nombre_empresa"] = $data["nombre"];
					echo "1";
				}
				else
				{	
					$data = mysqli_fetch_array($result);
					session_start();
					$_SESSION["suscripcion"] = "Contrata un plan";
					$_SESSION["ofertas_restantes"] = 0;
					$_SESSION["email_empresa"] = $data["correo"];
					$_SESSION["nombre_empresa"] = $data["nombre"];

					echo "1";
				}
			}
			else
			{
				echo "3";
			}

			/*$sql = "SELECT correo,contrata.nombre_suscripcion,contrata.ofertas_restantes,empresa.nombre FROM empresa inner join contrata on contrata.correo_empresa=empresa.correo 
			WHERE correo='$correo' AND clave='$pass_hash' AND contrata.activo =1 AND empresa.activo =1";

			$result = mysqli_query($connect,$sql);

			$num_row = mysqli_num_rows($result);

			if($num_row == "1")
			{	
				
				session_start();
				$data = mysqli_fetch_array($result);
				$_SESSION["email_empresa"] = $data["correo"];
				$_SESSION["suscripcion"] = $data["nombre_suscripcion"];
				$_SESSION["ofertas_restantes"] = $data["ofertas_restantes"];
				$_SESSION["nombre_empresa"] = $data["nombre"];
				echo "1";
			}	*/
		}
	}
	else
	{
		echo "3";
	}

?>