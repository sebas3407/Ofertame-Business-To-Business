$(document).ready(function() {

	var control_nomnbre =  true;
	var control_unidades  = true;
	var control_descripcion = true;
	var control_fecha = true;
	var control_foto = false;
	var control_categoria = false;

	var nombre = $("#nombre").val();
	var unidades = $("#unidades").val();
	var fecha = $("#fecha").val();
	var foto = "";
	var categoria = "";
	var descripcion = $("#descripcion").val();

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
			$("#date_error").html("La fecha selecionada es menor o igual a la de hoy");
			$("#date_error").show();
		}
		else
		{	
			control_fecha = true;
			$("#date_error").hide();
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

	$("#btn_crear").click(function(){

		foto = $("#foto").val();
		ofertaID = $("#ofertaID").text();

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
			formData.append("ofertaid",ofertaID);
			formData.append("foto",file);

			$.ajax({
				url: "php/modificar_oferta2.php",
				method: "POST",
				data: formData,
				contentType: false,
				cache: "false",
				processData: false,
				beforeSend:function() 
				{            
					$("#btn_crear").val("Modificando oferta... ");
				},
				success:function(data) 
				{	
					$("#btn_crear").val("Modificar oferta");
					if (data == "3")
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
				}
			});
		}
		else
		{
			$("#text_message").html("<br><div class='alert alert.dismissible alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong><p style='font-size:16px;'>¡Error!</strong>Hay campos erróneos o en blanco</p></div>");
		}

	});
})