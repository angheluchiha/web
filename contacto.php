<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contacto del Restaurante</title>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/estilo.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<?php include("includes/menu.php"); ?>
	

<div class="container-fluid">
  <div class="row">
   <h1 class="text-center">Contactanos</h1>
   <hr class="linea">
<div class="container">
 
	<div class="row">
		<div class="col-sm-4">
			<p class="justificado">
		Sus comentarios son muy importantes para nosotros, por favor llene los campos solicitados a continuaciòn y envianos sus sugerencias.
		</p>
			<img src="img/logo/contacto.jpg" width="400" class="img-circle img-responsive visible-lg visible-md visible-sm"> </div>
		<div class="col-sm-4">
			<p class="justificado">
		Contàctenos, atenderemos sus dudad y le presentaremos un esquema a sus necesidades. Use algunos de los medios de redes sociales disponible o deje sus datos y nos comunicàremos con usted lo mas pronto posible.
		</p>
			<div class="col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8 form-contacto" >
			<form class="form-horizontal" name="contacto" id="contacto" action="email_contacto.php" method="post"></input>
				<div class="form-group">
				<div class="col-xs-offset-1 col-xs-10">
					<label>Nombre:</label>
			<input class="form-control" type="text" name="nombre" id="nombre" required placeholder="Nombre Completo"></input>
					</div>
				</div>
			
			<div class="form-group">
				<div class="col-xs-offset-1 col-xs-10">
				<label>Email:</label>
			<input class="form-control" type="email" name="email" id="email" required placeholder="Correo Elèctronico"></input>
				</div>
				</div>
		
		<div class="form-group">
				<div class="col-xs-offset-1 col-xs-10">
			<label>Web:</label>
		   <input class="form-control" type="text" name="web" id="web" placeholder="Sitio Web"></input>
			</div>
				</div>
	
		<div class="form-group">
				<div class="col-xs-offset-1 col-xs-10">
	<label>Mensaje:</label>
				<textarea class="form-control" name="msj" id="msj" rows="4" required placeholder="Ingrese su Mensaje"></textarea>
							</div>
				</div>
	<div class="form-group">
				<div class="col-xs-offset-1 col-xs-10">
<input class="btn btn-success btn-lg pull-right" type="submit" value="Enviar"></input>
					</div>
				</div>

		</form>
	</div> 
    
			</div>
		
		</div>
		
  </div>
  <hr class="linea">
	<?php include("includes/footer.php"); ?>
  


</html>
