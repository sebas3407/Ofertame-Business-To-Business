$(document).ready(function() {

	var control_nomnbre =  false;
	var control_unidades  = false;
	var control_descripcion = false;
	var control_fecha = false;
	var control_foto = false;
	var control_categoria = false;

	var nombre = "";
	var unidades = "";
	var fecha = "";
	var foto = "";
	var categoria = "";
	var descripcion = "";

	$("#nombre").focusout(function() {

		checkNombre();

	});

	$("#unidades").focusout(function() {

		checkUnidades();

	});

	$("#categoria").focusout(function() {

		checkCategoria();

	});


	$("#fecha").focusout(function() {

		checkFecha();

	});

	$("#descripcion").focusout(function() {

		checkDescripcion();

	});


	function checkFecha()
	{
		fecha = $("#fecha").val();

		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1;
		var yyyy = today.getFullYear();

		if(dd<10) {
		    dd = '0'+dd
		} 

		if(mm<10) {
		    mm = '0'+mm
		} 

		today = yyyy + "-" + mm + "-" + dd;

		if (fecha <= today)
		{
			control_fecha = false;
			$("#date_error").html("La fecha selecionada ha de ser superior a la de hoy");
			$("#date_error").show();
		}
		else
		{	
			control_fecha = true;
			$("#date_error").hide();
		}
		
	}

	function checkCategoria()
	{
		categoria = $("#categoria option:selected").val();

		if (categoria == "categoria")
		{
			control_categoria = false;
			$("#categoria_error").html("Selecciona una categoría correcta");
			$("#categoria_error").show();
		}
		else
		{
			control_categoria = true;
			$("#categoria_error").hide();
		}

	}

	function checkUnidades()
	{
		unidades = $("#unidades").val();

		if (unidades < 1)
		{
			control_unidades = false;
			$("#unidades_error").html("Al menos 1 unidad disponible");
			$("#unidades_error").show();
		}
		else
		{
			control_unidades = true;
			$("#unidades_error").hide();
		}
	}


	function checkDescripcion()
	{
		descripcion = $("#descripcion").val().length;

		if (descripcion < 10)
		{
			control_descripcion = false;
			$("#descripcion_error").html("Mínimo 10 carácteres");
			$("#descripcion_error").show();
		}
		else
		{
			descripcion = $("#descripcion").val();
			control_descripcion = true;
			$("#descripcion_error").hide();
		}
	}

	function checkNombre()
	{
		nombre = $("#nombre").val().length;

		if (nombre < 10)
		{
			control_nomnbre = false;
			$("#nombre_error").html("Mínimo 10 carácteres");
			$("#nombre_error").show();
		}
		else
		{
			nombre = $("#nombre").val();
			$("#nombre_error").hide();
			control_nomnbre = true;
		}
	}

	$("#btn_crear").click(function(){

		foto = $("#foto").val();

		if (control_nomnbre == true && control_categoria == true && control_descripcion == true && control_unidades == true && control_fecha == true && foto!="")
		{	
			var formData = new FormData();
			var input = document.querySelector('input[type=file]'),
			file = input.files[0];

			formData.append("nombre",nombre);
			formData.append("descripcion",descripcion);
			formData.append("categoria", categoria);
			formData.append("fecha",fecha);
			formData.append("unidades",unidades);
			formData.append("foto",file);

			$.ajax({
				url: "php/crear_oferta.php",
				method: "POST",
				data: formData,
				contentType: false,
				cache: "false",
				processData: false,
				beforeSend:function() 
				{            
					$("#btn_crear").val("Creando oferta... ");
				},
				success:function(data) 
				{	
					$("#btn_crear").val("Crear oferta");
					if(data  == "1")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>No te quedan más ofertas restantes!</p></div>");
					}
					else if (data == "2")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>No se ha podido crear la oferta</p></div>");
					}
					else if (data == "3")
					{
						$(location).attr("href","mis-ofertas.html");
					}
					else if (data == "4")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>El tamaño es demasiado grande. Máximo 1 MB.</p></div>");
					}
					else if (data == "5")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>Formato de imagen no admitido.</p></div>");
					}
					else if (data == "6")
					{
						$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>La imagen ha de ser 700x400</p></div>");
					}
					else if (data == "7")
					{
						$(location).attr("href","mis-ofertas.html");
					}
				}

			});
		}
		else
		{
			$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>¡Error!</strong>Hay información incorecta</p></div>");
		}

	});
});