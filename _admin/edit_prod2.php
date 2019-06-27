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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_prod")) {
	
	mysql_select_db($database_menu, $menu);
	$query_ImgProducto = sprintf("SELECT img_prod FROM tbl_productos WHERE tbl_productos.id_prod = ".$_POST['id_prod']);
	$ImgProducto = mysql_query($query_ImgProducto, $menu) or die (mysql_error());
	$row_ImgProducto = mysql_fetch_assoc($ImgProducto);
	$totalRows_ImgProducto = mysql_num_rows($ImgProducto);
	
	$img = $row_ImgProducto["img_prod"];
	
	if($_POST['img_prod'] == $img){

  $updateSQL = sprintf("UPDATE tbl_productos SET nom_pro=%s, min_desc_prod=%s, desc_pro=%s, prec_prod=%s, cant_prod=%s, img_prod=%s, id_cat_prod=%s WHERE id_prod=%s",
                       GetSQLValueString($_POST['nom_pro'], "text"),
                       GetSQLValueString($_POST['min_desc_prod'], "text"),
                       GetSQLValueString($_POST['desc_pro'], "text"),
                       GetSQLValueString($_POST['prec_prod'], "double"),
                       GetSQLValueString($_POST['cant_prod'], "int"),
                       GetSQLValueString($_POST['img_prod'], "text"),
                       GetSQLValueString($_POST['id_cat_prod'], "int"),
                       GetSQLValueString($_POST['id_prod'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "edit_prod.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}else{
	
	unlink ("../img/comida/".$img);
	
	$updateSQL = sprintf("UPDATE tbl_productos SET nom_pro=%s, min_desc_prod=%s, desc_pro=%s, prec_prod=%s, cant_prod=%s, img_prod=%s, id_cat_prod=%s WHERE id_prod=%s",
                       GetSQLValueString($_POST['nom_pro'], "text"),
                       GetSQLValueString($_POST['min_desc_prod'], "text"),
                       GetSQLValueString($_POST['desc_pro'], "text"),
                       GetSQLValueString($_POST['prec_prod'], "double"),
                       GetSQLValueString($_POST['cant_prod'], "int"),
                       GetSQLValueString($_POST['img_prod'], "text"),
                       GetSQLValueString($_POST['id_cat_prod'], "int"),
                       GetSQLValueString($_POST['id_prod'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "edit_prod.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
	}
}

mysql_select_db($database_menu, $menu);
$query_DatosCategoria = "SELECT * FROM tbl_categorias";
$DatosCategoria = mysql_query($query_DatosCategoria, $menu) or die(mysql_error());
$row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
$totalRows_DatosCategoria = mysql_num_rows($DatosCategoria);

$varProd_DatosProductos = "0";
if (isset($_GET["edit_ID"])) {
  $varProd_DatosProductos = $_GET["edit_ID"];
}
mysql_select_db($database_menu, $menu);
$query_DatosProductos = sprintf("SELECT * FROM tbl_productos WHERE tbl_productos.id_prod = %s", GetSQLValueString($varProd_DatosProductos, "int"));
$DatosProductos = mysql_query($query_DatosProductos, $menu) or die(mysql_error());
$row_DatosProductos = mysql_fetch_assoc($DatosProductos);
$totalRows_DatosProductos = mysql_num_rows($DatosProductos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Producto</title>

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

<script>
function CargarImagen()
{
	self.name = 'opener';
	remote = open ('img_producto.php', 'remote', 'width=500, height=450, location=no, scrollbars=yes, menubars=no, toolbars=no, rezisable=no, fullscreen=no, status=yes');
	remote.focus();
	}
</script>


</head>
<body>
	<?php include("../includes/menu_admin.php"); ?>
  
   
	


   
<div class="container">
<h1 class="text-center">Editar Producto</h1>
<p>&nbsp;</p>

<div class="col-sm-offset-3 col-sm-6">
  
  <form class="form-horizontal" name="form_prod" id="form_prod" action="<?php echo $editFormAction; ?>" method="POST">
  <div class="form-group">
  <div class="col-xs-12 col-sm-6">
   
 <input class="form-control" type="text" name="nom_pro" id="nom_pro" value="<?php echo $row_DatosProductos['nom_pro']; ?>" placeholder="Nombre producto" required>
  </div>
  <div class="col-xs-12 col-sm-6">
 <input class="form-control" type="text" name="prec_prod" id="prec_prod"  value="<?php echo $row_DatosProductos['prec_prod']; ?>" placeholder="Precio  producto "  required ></input>
 </div>
  </div>
  
  
   <div class="form-group">
  <div class="col-xs-12">
 <input class="form-control" type="text" name="min_desc_prod" id="min_desc_prod" value="<?php echo $row_DatosProductos['min_desc_prod']; ?>" placeholder="Descripción  producto 1" required ></input>
 </div>
  </div>
  
   <div class="form-group">
  <div class="col-xs-12">
  <textarea class="form-control" rows="6" type="text" name="desc_pro" id="desc_pro"  placeholder="Descripción  producto 2" required><?php echo $row_DatosProductos['desc_pro']; ?></textarea>
 </div>
  </div>
  
 
  
  <div class="form-group">
  <div class="col-xs-12 col-sm-6">
 <input class="form-control" type="text" name="cant_prod" id="cant_prod" value="<?php echo $row_DatosProductos['cant_prod']; ?>" placeholder="cantidad  producto " required ></input>
 </div>
  <div class="col-xs-12 col-sm-6">
 
    <select class="form-control" name="id_cat_prod" id="id_cat_prod">
      <option value="" <?php if (!(strcmp("", $row_DatosProductos['id_cat_prod']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
      <?php
do {  
?>
      <option value="<?php echo $row_DatosCategoria['id_cat']?>"<?php if (!(strcmp($row_DatosCategoria['id_cat'], $row_DatosProductos['id_cat_prod']))) {echo "selected=\"selected\"";} ?>><?php echo $row_DatosCategoria['nom_cat']?></option>
      <?php
} while ($row_DatosCategoria = mysql_fetch_assoc($DatosCategoria));
  $rows = mysql_num_rows($DatosCategoria);
  if($rows > 0) {
      mysql_data_seek($DatosCategoria, 0);
	  $row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
  }
?>
    </select>
  </div>
   </div>
   
 <div class="form-group">
  <div class="col-xs-12 col-sm-6">
   
    <div align="right"><img src="../img/comida/<?php echo $row_DatosProductos['img_prod']; ?>" class="img-responsive img-circle" width="150"></div>
  </div>
  <div class="col-xs-12 col-sm-6">
 <input class="form-control" type="text" name="img_prod" id="img_prod" value="<?php echo $row_DatosProductos['img_prod']; ?>" placeholder="Imagen producto" onClick="javascript:CargarImagen();" style="cursor:pointer;" required readonly ></input>
 </div>
  </div>
  
  
  <div class="form-group">
  <div class="col-xs-12">
    <div align="center">
      <input class="btn btn-primary" type="submit" value="Editar Comida"></input>
    </div>
  </div>
  </div>
  <input type="hidden" name="id_prod" value="<?php echo $row_DatosProductos['id_prod']; ?>">
  <input type="hidden" name="MM_update" value="form_prod">
  
 </form>
 </div>

		
</div>
	
<hr>
	<?php include("../includes/footer_admin.php"); ?>
  
  <hr>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>
<script type="text/javascript">

</script>
</body>
</html>
<?php
mysql_free_result($DatosCategoria);

mysql_free_result($DatosProductos);
?>
