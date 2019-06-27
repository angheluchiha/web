<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Cargar Imagen</title>

<!-- Bootstrap -->
<link href="../css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/fileinput.css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">

<?php 
if((isset($_POST["enviado"]))&& ($_POST["enviado"] =="form1")){
	
		if(file_exists("../img/comida/".$_FILES["userfile"]["name"])){
		echo '<p class="alert alert-danger text-center">Lo sentimos ya existe una imagen con el nombre <b>'.$_FILES["userfile"]["name"].'</b>, por favor cambiale el nombre o elija otra imagen.</p> <center><input class="btn btn-danger" name="button" type="button" onclick="window.close();" value="Cerrar Ventana"/></center>';
		}else{
			
			if(($_FILES['userfile']['type']!='image/jpeg')&&($_FILES['userfile']['type']!='image/png'))
			{
			echo'<p class="alert alert-danger text-center">Solo se permite las imagenes "jpg o png".<br>
el tamaño maximo es de <b>5 mb</b></p>';

?>

<form class="form-horizontal" name="form1" id="form1" method="post" action="img_producto.php" enctype="multipart/form-data">



<div class="form-group">
<div class="col-xs-12">
<input type="file" class="file" name="userfile" id="userfile">
</div>
</div>

<div class="form-group">
<div class="col-xs-12 text-right">
<input type="submit" class="btn btn-primary" value="Cargar Imagen">
<input type="button" class="btn btn-danger" value="Cerrar" onClick="window.close();">
</input>
</div>
</div>
<input type="hidden" name="enviado" value="form1">
</input>
</input>
</input>

</form>
</div>

<?php 
			}else{
				
				if($_FILES['userfile']['size']<=5000000){

	
	$nombre_archivo	=$_FILES["userfile"]["name"];
	move_uploaded_file($_FILES["userfile"]["tmp_name"],"../img/comida/".$nombre_archivo);
	}else{
		echo "<div class='alert alert-danger text-center'> Lo sentimos el archivo es muy grande</div>";
		
		?>
        <form class="form-horizontal" name="form1" id="form1" method="post" action="img_producto.php" enctype="multipart/form-data">



<div class="form-group">
<div class="col-xs-12 text-right">
<input type="file" class="file" name="userfile" id="userfile">
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
<input type="submit" class="btn btn-primary" value="Cargar Imagen">
<input type="button" class="btn btn-danger" value="Cerrar" onClick="window.close();">
</input>
</div>
</div>
<input type="hidden" name="enviado" value="form1">
</input>
</input>
</input>

</form>
</div>
        <?php
		}
	}
	}
?>
<script>
opener.document.form_prod.img_prod.value="<?php echo $nombre_archivo; ?>";
self.close();
</script>

<?php }else { ?>
<form class="form-horizontal" name="form1" id="form1" method="post" action="img_producto.php" enctype="multipart/form-data">
<div class="alert alert-success" class="text-center">
El tamaño maximo es de <strong>5 mb</strong>
</div>


<div class="form-group">
<div class="col-xs-12 text-right">
<input type="file" class="file" name="userfile" id="userfile">
</div>
</div>

<div class="form-group">
<div class="col-xs-12">
<input type="submit" class="btn btn-primary" value="Cargar Imagen">
<input type="button" class="btn btn-danger" value="Cerrar" onClick="window.close();">
</input>
</div>
</div>
<input type="hidden" name="enviado" value="form1">
</input>
</input>
</input>

</form>
</div>
	 
<?php } ?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>
<script src="../js/fileinput.js"></script>
</body>
</html>
