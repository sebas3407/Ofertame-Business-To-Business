$(document).ready(function() {

	var control_nombre = false;
	var control_email = false;
	var control_telefono = false;
	var control_password = false;
	var control_direccion = false;


	var nombre = "";
	var suscripcion = "STANDARD";
	var email = "";
	var telefono = "";
	var password = "";

	$("#email_error").hide();
	$("#password_error").hide();
	$("#direccion_error").hide();
	$("#phone_error").hide();
	$("#name_error").hide();


	$("#email").focusout(function() {

		chekEmail();

	});

	$("#password").focusout(function() {

		chekPassword();

	});

	$("#suscripcion").focusout(function() {

		cheksuscripcion();

	});

	$("#telefono").focusout(function() {

		checkPhone();

	});

	$("#nombre").focusout(function() {

		checkName();

	});

	$("#direccion").focusout(function() {

		checkDireccion();

	});


	$("#btn_submit").click(function() {
		if (control_nombre == true && control_email == true && control_password == true  && control_direccion == true && control_telefono == true)
		{
			$.ajax({
				url: "php/validar_registro.php",
				method: "POST",
				data:{email:email, password:password, nombre:nombre, suscripcion:suscripcion, direccion:direccion, telefono:telefono},
				cache : "false",
				beforeSend:function() {
					$("#btn_submit").val("Registrando...");
				},
				success:function(data) {
					$("#btn_submit").val("Registrar");
					if(data  == "1")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>¡Error!</strong> El correo ya existe!</p></div>");
					}
					else if (data == "3")
					{
						$(location).attr("href","mis-ofertas.html");
					}
				}
			});
		}
	});

	function checkDireccion()
	{
		direccion = $("#direccion").val().length;

		if (direccion < 8)
		{	
			control_direccion = false;
			$("#direccion_error").html("M&#237;nimo 4 car&#225;cteres.");
			$("#direccion_error").show();
				
		}
		else
		{
			direccion = $("#direccion").val();
			control_direccion = true;
			$("#direccion_error").hide();
		}
	}

	function checkName()
	{
		nombre = $("#nombre").val().length;

		if (nombre < 3)
		{	
			control_nombre = false;
			$("#name_error").html("M&#205;nimo 4 car&#225;cteres.");
			$("#name_error").show();
				
		}
		else
		{
			nombre = $("#nombre").val();
			control_nombre = true;
			$("#name_error").hide();
		}


	}

	function chekEmail()
	{	
		var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[+a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$/i);
		email = $("#email").val();
		if (pattern.test(email))
		{	
			$("#email_error").hide();
			control_email = true;
		}
		else
		{
			control_email = false;
			$("#email_error").html("Formato correo incorrecto");
			$("#email_error").show();
			
		}
	}

	function chekPassword()
	{

		password = $("#password").val().length;

		if (password < 8)
		{
			$("#password_error").html("Almenos 8 car&#225;cteres.");
			$("#password_error").show();
			control_password = false;	
		}
		else
		{
			password = $("#password").val();
			$("#password_error").hide();
			control_password = true;
		}
	}

	function cheksuscripcion()
	{
		suscripcion = $("#suscripcion").val();
	}

	function checkPhone()
	{
		telefono = $("#telefono").val().length;

		if (telefono != 9)
		{	
			control_telefono = false;
			$("#phone_error").html("Formato tel&#233;fono inv&#225;lido.");
			$("#phone_error").show();
		}
		else
		{	
			telefono = $("#telefono").val();
			control_telefono = true;
			$("#phone_error").hide();
		}
	}


});