<?php require_once('../Connections/menu.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_menu, $menu);
$query_DatosCategorias = "SELECT * FROM tbl_categorias";
$DatosCategorias = mysql_query($query_DatosCategorias, $menu) or die(mysql_error());
$row_DatosCategorias = mysql_fetch_assoc($DatosCategorias);
$totalRows_DatosCategorias = mysql_num_rows($DatosCategorias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Categorias</title>

<!-- Bootstrap -->
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/estilos.css" rel="stylesheet">
	<link href="../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script src="../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script>
function CargarImagen()
{
	self.name = 'opener';
	remote = open ('img_categoria.php', 'remote', 'width=500, height=450, location=no, scrollbars=yes, menubars=no, toolbars=no, rezisable=no, fullscreen=no, status=yes');
	remote.focus();
	}
</script>


</head>
<body>
	<?php include("../includes/menu_admin.php"); ?>
<div class="container">
  <h1 class="text-center">Editar categorias </h1>
  <div class="table-responsive">
  <table class="table table-hover">
  <tbody>
  <tr bgcolor="#999999">
    <th scope="col">N°</h1></h1></th>
    <th scope="col">imagen</th>
    <th scope="col">Categoria</th>
    <th scope="col">Estado</th>
    <th scope="col">Acciones</th>
  </tr>
  
  
 <?php 
  $contador = 1;
  ?>
  
   <?php do { ?>
  <tr>
    <td><?php echo $contador; ?></td>
    <td><img src="../img/menu/<?php echo $row_DatosCategorias['img_cat']; ?>" width="80"></td>
    <td><?php echo $row_DatosCategorias['nom_cat']; ?></td>
    <td><?php
	if($row_DatosCategorias['st_cat'] == 1){
  echo "<font color='#195814'> <strong>Activo</strong></font>";
}else{
	echo"<font color='#a40d0f'> <strong>Inactivo</strong></font>";
	}
	 ?></td>
    <td>
    <a href="edit_cat2.php?edit_ID=<?php echo $row_DatosCategorias['id_cat']; ?>" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
     </td>
   </tr>
   
   <?php 
  $contador = $contador + 1
  ?>
  
    <?php } while ($row_DatosCategorias = mysql_fetch_assoc($DatosCategorias)); ?>
    </tbody>
</table>
</div> 
</div>
	
<hr>
	<?php include("../includes/footer_admin.php"); ?>
  
  <hr>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>

</body>
</html>
<?php
mysql_free_result($DatosCategorias);
?>
