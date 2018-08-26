<?php

header("Content-Type: text/html;charset=utf-8");
include_once("model.php");

if (isset($_POST["opcion"]))
  {
    $opcion = $_POST["opcion"];
    switch ($opcion)
    {
        case "login":

          $code = $_POST["code"];
          $password = $_POST["password"];

          if(CheckUser($email,$password))
          {
            $_SESSION['code']=$code;
            $_SESSION['password']=$password;

            header("Location: perfil.html");
            
          }
          else
          {
            header("Location: registro.html");
          }
        break;

        case "register":
      
   
        break;
    }
  }
else
  {
    show_error(-6);
  }
?>