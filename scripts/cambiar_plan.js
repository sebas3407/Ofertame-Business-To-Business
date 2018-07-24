$(document).ready(function() {
	$("#btn_contratar").click(function() {

		var suscripcion = $("#suscripcion").val();

		$.ajax({
			url: "php/cambiar_plan.php",
			method: "POST",
			data:{suscripcion:suscripcion},
			cache: "false",
			beforeSend:function() 
			{
				$("#btn_contratar").val("Contratando... ");
			},
			success:function(data) 
			{
				$("#btn_contratar").val("Contratar");
				if(data  == "1")
				{
					$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>Tu suscripci&#243;n a&#250;n no ha caducado, o todav&#205;a te quedan ofertas restantes.</p></div>");
				}
				else if (data == "3")
				{
					$(location).attr("href","mis-ofertas.html");
				}
			}
		});
	});
});