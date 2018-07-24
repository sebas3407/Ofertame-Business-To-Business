<?php
date_default_timezone_set('Europe/Madrid');
header("Content-Type: text/html;charset=ansi");
include_once("accesbd.php");

function obtenir_inicialitzacions_bd(&$servidor, &$usuari, &$contrasenya, &$bd)
  {
    $servidor    = "localhost";
    $usuari      = "root";
    $contrasenya = "usbw";
    $bd          = "test_proyecto";
  }

function CheckUser($code, $password)
  {
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);

    $pass_hash = hash("md5","$password");

    if ($connexio)
      {
        $instruccio = "select count(*) from empresa where codigo_empresa ='$code' and clave = '$pass_hash'";
        $quants     = consulta_dada($connexio, $instruccio);
        $res = ($quants > 0);
        desconnectar_bd($connexio);
      }
      
    return $res;
  }

function CheckNewUserEmail($email) //Comprobar que el email de un usuario nuevo ya esté introducido
{
  $res = false;
  obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
  
  $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);

  if ($connexio)
    {
      $instruccio = "select count(*) from usuario where correo ='$email'";
      $quants     = consulta_dada($connexio, $instruccio);
      $res = ($quants > 0);
      desconnectar_bd($connexio);
    }
    
  return $res;
}

function CheckNewUserDNI($dni) //Comprobar que el email de un usuario nuevo ya esté introducido
{
  $res = false;
  obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
  
  $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);

  if ($connexio)
    {
      $instruccio = "select count(*) from usuario where dni ='$dni'";
      $quants     = consulta_dada($connexio, $instruccio);
      $res = ($quants > 0);
      desconnectar_bd($connexio);
    }
    
  return $res;
}

function AddUser($email, $password, $dni, $name, $lastName, $phone, $birthdate)
{
  $res = 0; //si $res = 0, tot va be
  
  obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
  
  $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
  if ($connexio)
  {
    $pass_hash = hash("md5","$password");

    $instruccio = "insert INTO usuario (correo,clave,dni,nombre,apellidos,telefono,fecha_nacimiento,tipo) VALUES('$email', '$pass_hash', '$dni', '$name', '$lastName', '$phone', '$birthdate', 'usuario')";
           
    if (executa_SQL($connexio, $instruccio))
      {
        $res = 0;
      }
    else
      {
        $res = -1; //-1 es: "Error en la instruccio SQL"
      }

    desconnectar_bd($connexio);
    return ($res);
  }
}

function num_files($res)
{
  $quants = 0;
  if (isset($res) && $res != null)
    {
      $quants = mysqli_num_fields($res);
    }
  return ($quants);
}


function adminOfertas()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        
        $instruccio = "SELECT * from oferta ";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);  

        echo "<table id='adminUsersT' style='text-align:center;'>";
        echo("<tr class='img_BG'>");
        echo "<th class='hidden-xs' style='text-align:center;'>NOMBRE OFERTA</th><th class='hidden-xs' style='text-align:center;'>EMPRESA</th><th style='text-align:center;'>DESCRIPCI&#211;N</th><th style='text-align:center;'>UNIDADES</th><th class='hidden-xs' style='text-align:center;'>FECHA INICIAL</th><th class='hidden-xs' style='text-align:center;'>FECHA FINAL</th>";
        echo("</tr>");
        echo("<tr>");
        while ($fila)
              {
                echo("<td class='hidden-xs'>".$fila[1]."</td><td class='hidden-xs'>".$fila[3]."</td><td style='max-width:300px;'>".$fila[4]."</td><td style='width:30px;'>".$fila[5]."</td><td class='hidden-xs' style='width:90px;'>".$fila[7]."</td><td class='hidden-xs' style='width:90px;'>".$fila[8]."</td><td class='img_bg_bt'><button class='bt_eliminar_user_table'>ELIMINAR</button></td>");
                echo "</tr>";
                $fila = obtenir_fila($consulta);
              }
          echo "</table><br>";
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
}

function adminEmpresas()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        
        $instruccio = "SELECT * from empresa";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);  

        echo "<table id='adminUsersT' style='text-align:center;'>";
        echo("<tr class='img_BG'>");
        echo "<th class='hidden-xs' style='text-align:center;'>NOMBRE EMPRESA</th><th style='text-align:center;'>TEL&#201;FONO</th><th class='hidden-xs' style='text-align:center;'>DIRECCI&#211;N</th><th class='hidden-xs' style='text-align:center;'>CORREO</th>";
        echo("</tr>");
        echo("<tr>");
        while ($fila)
              {
                echo("<td class='hidden-xs'>".$fila[0]."</td><td class='hidden-xs'>".$fila[2]."</td><td>".$fila[3]."</td><td class='hidden-xs' style='width:90px;'>".$fila[4]."</td><td class='img_bg_bt'><button class='bt_eliminar_user_table'>ELIMINAR</button></td>");
                echo "</tr>";
                $fila = obtenir_fila($consulta);
              }
          echo "</table><br>";
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
}

function misOfertas($empresa)
{
  
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT * FROM empresa INNER JOIN oferta ON empresa.nombre = oferta.nombre_empresa where correo = '$empresa'";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
               // echo "sebas sebas sebas";
                echo "<div class='col-md-4'>";
                echo "<br>";
                echo "<div class='imgO boxShadow'>
                      <img src='$fila[15]' height='100%' width='100%' style='border-radius:5px;'>
                      <p id ='tittle' class='titulo_oferta' style='height:45px;'>".$fila[7]."</p>
                      <hr>
                      <p id ='descripcion_oferta' class='descripcio_oferta'>".$fila[10]."</p>
                      <div id ='category' class='categoriaMain'><p id='categoria' class='ofertasPMain'>".$fila[8]."</p></div>
                      <div id ='company' class='empresaMain'><p id='n_empresa' class='ofertasPMain'>".$fila[9]."</p></div><br>
                      <div class='ofertasRestantesMain'><p class='ofertasPMain'>QUEDAN $fila[11] DISPONIBLE</p></div><br>
                      <div id ='endDate' class='fechaMain'><p class='ofertasPMain'>DISPONIBLE HASTA ".$fila[14]."</p></div>
                      <br>
                      <input type='button' id = 'btn_modificar' class='bt_mis-ofertas' value='MODIFICAR OFERTA'></a>
                      <p id='ofertaIDtext' hidden>".$fila[6]."</p></td>
                      <p id='cantidad_disponible' hidden>".$fila[11]."</p></td>
                      <p id='fin_oferta' hidden>".$fila[14]."</p></td>
                      </div> ";

                echo "<br></div>";
                  $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }

function estadisticas_1($empresa)
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT count(*)
        FROM oferta
        WHERE nombre_empresa = '$empresa'";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>OFERTAS CREADAS : ".$fila[0]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }

function estadisticas_2($empresa)
{
  
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT * 
          FROM oferta
          WHERE id_oferta = ( 
          SELECT COUNT( reserva.id_oferta ) AS cual
          FROM reserva
          INNER JOIN oferta ON oferta.id_oferta = reserva.id_oferta
          WHERE oferta.nombre_empresa =  'Pull and bear'
          GROUP BY reserva.id_oferta
          ORDER BY cual DESC 
          LIMIT 0,1)";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>OFERTA M&#193;S RESERVADA : ".$fila[1]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }

function estadisticas_3($empresa)
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT count(categoria_oferta) as number, categoria_oferta FROM OFERTA where nombre_empresa = '$empresa' group by categoria_oferta order by number desc limit 0,1;";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>CATEGOR&#205;A QUE M&#193;S UTILIZO : ".$fila[1]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }

function estadisticas_6()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT COUNT(*) FROM OFERTA";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>OFERTAS EN TOTAL : ".$fila[0]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }
function estadisticas_7()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT COUNT( * ) FROM RESERVA";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>RESERVAS REALIZADAS : ".$fila[0]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }
function estadisticas_8()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT COUNT( * ) FROM CATEGORIA";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>CANTIDAD DE CATEGOR&#205;AS : ".$fila[0]."</p>";
                $fila = obtenir_fila($consulta);
              }
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }
function estadisticas_9()
{
  
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT COUNT( * ) FROM USUARIO";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>USUARIOS REGISTRADOS: ".$fila[0]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }

function estadisticas_10()
{
    $res = false;
    obtenir_inicialitzacions_bd($servidor, $usuari, $contrasenya, $bd);
    $connexio = connectar_BD($servidor, $usuari, $contrasenya, $bd);
    if ($connexio)
      {
        $instruccio = "SELECT count(categoria_oferta) as number, categoria_oferta FROM OFERTA group by categoria_oferta order by number desc limit 0,1;";

        $consulta   = consulta_multiple($connexio, $instruccio);
        $fila = obtenir_fila($consulta);
        
        while ($fila)
              {
                echo "<p class='ofertas_esta'>CATEGOR&#205;A M&#193;S UTILIZADA : ".$fila[1]."</p>";
                $fila = obtenir_fila($consulta);
              }
          
        
        tancar_consulta_multiple($consulta);
      }
    desconnectar_bd($connexio);
    return ($res);
  }
?>