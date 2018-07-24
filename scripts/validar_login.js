$(document).ready(function() {
	$("#btn_submit").click(function() {
		
		var email = $('#email').val();
		var password = $('#password').val();

		if ($.trim(email).length > 0 && $.trim(password).length > 0)
		{	
			$.ajax({
				url: "php/validar_login.php",
				method: "POST",
				data:{email:email, password:password},
				cache: "false",
				beforeSend:function() {
					$("#btn_submit").val("Conectando...");
				},
				success:function(data) {
					$("#btn_submit").val("Entrar");
					if (data == "1")
					{
						$(location).attr("href","mis-ofertas.html");
					}
					else if (data == "2")
					{
						$(location).attr("href","zonaAdmin.html");
					}
					else if (data == "3")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>¡Error!</strong>Datos incorrectos o la empresa no existe.</p></div>");
					}
				}
			});
		};
	});
});