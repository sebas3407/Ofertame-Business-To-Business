<?php
	
	session_start();
	date_default_timezone_set('Europe/Madrid');
	$connect = mysqli_connect("localhost","root","usbw","test_proyecto");

	$direccion = $_POST["direccion"];
	$clave = $_POST["clave"];
	$telefono = $_POST["telefono"];
	$correo = $_SESSION["email_empresa"];

	if (strlen($clave) > 16)
	{
		$pass_hash = $clave;
	}
	else
	{
		$pass_hash = hash("md5","$clave");
	}

	$sql = "UPDATE empresa SET clave='$pass_hash',telefono='$telefono',direccion='$direccion' where correo='$correo'";

	if (mysqli_query($connect,$sql))
	{	
		echo "3";	

	}
	else
	{
		echo "2";
	}
	
?>