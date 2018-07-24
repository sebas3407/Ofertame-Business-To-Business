<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('Europe/Madrid');
session_start();

$ofertaID = $_GET["ofertaID"];
$fin_oferta = $_GET["fin_oferta"];
$cantidad_disponible = $_GET["cantidad_disponible"];
$tittle = $_GET["tittle"];
$descripcion_oferta = $_GET["descripcion_oferta"];
$categoria = $_GET["categoria"];

$_SESSION["ofertaID"] = $ofertaID;
$_SESSION["fin_oferta"] = $fin_oferta;
$_SESSION["cantidad_disponible"] = $cantidad_disponible;
$_SESSION["tittle"] = $tittle;
$_SESSION["descripcion_oferta"] = $descripcion_oferta;
$_SESSION["categoria"] = $categoria;

header("Location: modificar-oferta.html");

?>