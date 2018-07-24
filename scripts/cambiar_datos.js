$(document).ready(function() {

	var control_clave = true;
	var control_direccion = true;
	var control_telefono = true;
	var direccion;
	var telefono;
	var clave;

	$.ajax({
		url: "php/devolver_datos.php",
		method: "POST",
		data:{},
		cache : "false",
		beforeSend:function() {
			
		},
		success:function(data) {	
			ponerDatos(data);
		}

	});

	$("#direccion").focusout(function() {

		checkDireccion();

	});

	$("#telefono").focusout(function() {

		checkPhone();

	});

	$("#clave").focusout(function() {

		checkPassword();

	});


	function ponerDatos(response)
	{	

		var arr = JSON.parse(response);

		$("#direccion").val(arr[0].direccion);
		$("#clave").val(arr[0].clave);
		$("#telefono").val(arr[0].telefono);
	}

	function checkPhone()
	{
		telefono = $("#telefono").val().length;

		if (telefono != 9)
		{	
			control_telefono = false;
			$("#text_telefono").html("Formato teléfono inválido.");
			$("#text_telefono").show();
		}
		else
		{	
			telefono = $("#telefono").val();
			control_telefono = true;
			$("#text_telefono").hide();
		}

	}

	function checkPassword()
	{
		password = $("#clave").val().length;

		if (password < 8)
		{
			$("#text_contraseña").html("Clave entre 8 y 16 carácteres.");
			$("#text_contraseña").show();
			control_password = false;	
		}
		else
		{
			password = $("#clave").val();
			$("#text_contraseña").hide();
			control_password = true;
		}
	}

	function checkDireccion()
	{
		direccion = $("#direccion").val().length;

		if (direccion < 8)
		{	
			control_direccion = false;
			$("#text_direccion").html("Dirección mínimo 8 carácteres.");
			$("#text_direccion").show();
				
		}
		else
		{
			direccion = $("#direccion").val();
			control_direccion = true;
			$("#text_direccion").hide();
		}
	}

	$("#btn_cambiar").click(function() {

			
		if (control_telefono == true && control_direccion == true && control_clave == true)
		{
			direccion = $("#direccion").val();
			telefono = $("#telefono").val();
			clave = $("#clave").val();

			$.ajax({
				url: "php/cambiar_datos.php",
				method: "POST",
				data:{direccion:direccion, telefono:telefono, clave:clave},
				cache: "false",
				beforeSend:function() {
					$("#btn_submit").val("Modificando...");
				},
				success:function(data) {
					$("#btn_cambiar").val("Cambiar datos");
					if (data == "3")
					{
						$(location).attr("href","perfil.html");
					}
					else if (data == "2")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>¡Error!</strong> En el SQL.</p></div>");
					}
				}
			});
		}
		else
		{
			$("#text_message").html("Hay datos incorrectos.");
			$("#text_message").show();
		}
	});




});