<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administración</title>

<!-- Bootstrap -->
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/estilo.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div align="center">
	  <?php include("../includes/menu_admin.php"); ?>
</div>
  <h1 align="center">Bienvenido a la Administración</h1>
  <h2 align="center"><?php echo $row_DatosUser["nom_user"]?></h2>
  <br>

   <hr class="linea" >


<div class="container">

 <center> <img src="../img/logo/administracion.jpg" width="400" height="400"  class="img-responsive"></center><br>


<div class="row">

<div class="col-sm-4 col-sm-offset-1 mivi">
<h2 class="text-center" >Misión</h2>
<p class="text-justify" >Ofrecer a nuestro clientes la comida mexicana y servicio de la mas alta calidad, al precio justo, en el àmbito adecuado, procurando su mas amplia sastifacciòn a travès de un esmerado servicio personalizado.</p>
  </div>
  
  <div class="col-sm-4 col-sm-offset-2 mivi">
  <h2 class="text-center">Visión</h2>
  <p class="text-justify" >Consolidar y mantener el liderazgo de nuestro restaurante en el mercado, integrando los objetivos de los clientes, personal. proovedores y accionistas.<br>


</p>
  </div>
  
  </div>
</div>
	
<hr class="linea">
	<?php include("../includes/footer_admin.php"); ?>
  
  <hr>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>
</body>
</html>
