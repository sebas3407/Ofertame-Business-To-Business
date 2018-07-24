$(document).ready(function() {

	$(".col-md-4").click(function() {
		
	    ofertaID =  $(this).find("#ofertaIDtext").text();
	    fin_oferta =  $(this).find("#fin_oferta").text();
	    cantidad_disponible =  $(this).find("#cantidad_disponible").text();
	    tittle =  $(this).find("#tittle").text();
	    descripcion_oferta = $(this).find("#descripcion_oferta").text();
	    categoria = $(this).find("#categoria").text();

	    /*alert(ofertaID);
	    alert(cantidad_disponible);
	    alert(tittle);
	    alert(fin_oferta);
	    alert(categoria);
	    alert(descripcion_oferta);*/

		window.location.assign("modificar_oferta.php?ofertaID="+ofertaID+
		"&fin_oferta="+fin_oferta+
		"&cantidad_disponible="+cantidad_disponible+
		"&tittle="+tittle+
		"&descripcion_oferta="+descripcion_oferta+
		"&categoria="+categoria);
	
	});

});