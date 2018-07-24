<?php
	session_start();

	$email = $_SESSION['email_empresa'];

	header ('Content-type: text/html; charset=utf-8');

	$link = mysql_connect('localhost', 'root', 'usbw') or die('Error: ' . mysql_error());
		mysql_select_db('test_proyecto') or die('Error al seleccionar la base de dades');
		mysql_set_charset('utf8', $link);

		$query = "SELECT direccion,telefono,clave FROM empresa WHERE correo= '$email'";
		$result = mysql_query($query) or die('Error: ' . mysql_error());

		$emp = array();

		while($row = mysql_fetch_array($result))
		{
			$direccion = $row['direccion'];
			$telefono = $row['telefono'];
			$clave = $row['clave'];
			

			$emp[] = array('direccion'=> $direccion,'telefono'=> $telefono, 'clave'=> $clave);
		}

		$json_string = json_encode($emp);
		echo $json_string;

?>