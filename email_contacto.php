<?php

/* Recepcionamos los datos enviados asincrónicamente */
	
	$nombre = $_POST["nombre"];
	$email = $_POST["email"] ;
	$web = $_POST["web"] ;
	$mensaje = $_POST["msj"] ;
	
//Incluimos la clase de PHPMailer
require("PHPMailer/class.phpmailer.php");
include("PHPMailer/class.smtp.php");

//Creamos una instancia en lugar usar mail()
$mail = new PHPMailer();

//Usamos el SetFrom para decirle al script quien envia el correo
$mail->SetFrom("$nombre");
 
//Usamos el AddReplyTo para decirle al script a quien tiene que responder el correo
$mail->AddReplyTo($email,$nombre);
//Usamos el AddAddress para agregar un destinatario
$mail->AddAddress("garcesanghel@gmail.com");
$mail->AddAddress($email);
 
//Ponemos el asunto del mensaje
$mail->Subject = "Contacto Restaurante Lebanoon";
 
/*
 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
 
 * Si deseamos enviarlo en texto plano, haremos lo siguiente:
 * $correo->IsHTML(false);
 * $correo->Body = "Mi mensaje en Texto Plano";
 */

$cuerpo ="<html>
          <head>
		  </head>
		  <body>";

$cuerpo .="Hola: ".$nombre."<br /><br />
".$email."<br /><br />
".$web."<br /><br />
".$mensaje."


"; 

$cuerpo .="</body>
           </html>";

$mail->MsgHTML($cuerpo);

/* Enviamos vía correo, regresandomos a la pagina donde comentamos*/ 
	
	if($mail->Send()) {

header("Location: contacto.php?envio=true");

}else{
	
	header("Location: contacto.php?envio=false");
	return false;
		
	}	
	
?>
