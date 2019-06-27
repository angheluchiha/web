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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_prod")) {
  $insertSQL = sprintf("INSERT INTO tbl_productos (nom_pro, min_desc_prod, desc_pro, prec_prod, cant_prod, img_prod, id_cat_prod) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nom_pro'], "text"),
                       GetSQLValueString($_POST['min_desc_prod'], "text"),
                       GetSQLValueString($_POST['desc_pro'], "text"),
                       GetSQLValueString($_POST['prec_prod'], "double"),
                       GetSQLValueString($_POST['cant_prod'], "int"),
                       GetSQLValueString($_POST['img_prod'], "text"),
                       GetSQLValueString($_POST['id_cat_prod'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($insertSQL, $menu) or die(mysql_error());

  $insertGoTo = "add_menu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_menu, $menu);
$query_DatosCategoria = "SELECT * FROM tbl_categorias";
$DatosCategoria = mysql_query($query_DatosCategoria, $menu) or die(mysql_error());
$row_DatosCategoria = mysql_fetch_assoc($DatosCategoria);
$totalRows_DatosCategoria = mysql_num_rows($DatosCategoria);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ingresar Menú</title>

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
	remote = open ('img_producto.php', 'remote', 'width=500, height=450, location=no, scrollbars=yes, menubars=no, toolbars=no, rezisable=no, fullscreen=no, status=yes');
	remote.focus();
	}
</script>


</head>
<body>
	<?php include("../includes/menu_admin.php"); ?>
  
   
	


   
<div class="container">
<h1 class="text-center">Ingresar Menú</h1>
<p>&nbsp;</p>

<div class="col-sm-offset-3 col-sm-6">
 
 <form class="form-horizontal" name="form_prod" id="form_prod" action="<?php echo $editFormAction; ?>" method="POST">
  <div class="form-group">
  <div class="col-xs-12 col-sm-6">
   
 <input class="form-control" type="text" name="nom_pro" id="nom_pro" placeholder="Nombre producto" required>
  </div>
  <div class="col-xs-12 col-sm-6">
 <input class="form-control" type="text" name="prec_prod" id="prec_prod" placeholder="Precio  producto "  required ></input>
 </div>
  </div>
  
  
   <div class="form-group">
  <div class="col-xs-12">
 <input class="form-control" type="text" name="min_desc_prod" id="min_desc_prod" placeholder="Descripción  producto 1" required ></input>
 </div>
  </div>
  
   <div class="form-group">
  <div class="col-xs-12">
  <textarea class="form-control" rows="6" type="text" name="desc_pro" id="desc_pro" placeholder="Descripción  producto 2" required></textarea>
 </div>
  </div>
  
 
  
  <div class="form-group">
  <div class="col-xs-12 col-sm-6">
 <input class="form-control" type="text" name="cant_prod" id="cant_prod" placeholder="cantidad  producto " required ></input>
 </div>
  <div class="col-xs-12 col-sm-6">
 
    <select class="form-control" name="id_cat_prod" id="id_cat_prod">
     <option>Seleccione</option>
      <?php
do {  
?>
      <option value="<?php echo $row_DatosCategoria['id_cat']?>"><?php echo $row_DatosCategoria['nom_cat']?></option>
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
  <div class="col-xs-12">
 <input class="form-control" type="text" name="img_prod" id="img_prod" placeholder="Imagen producto" onClick="javascript:CargarImagen();" style="cursor:pointer;" required readonly></input>
 </div>
  </div>
  
  
  
  <div class="form-group">
  <div class="col-xs-12">
    <div align="center">
      <input class="btn btn-primary" type="submit" value="Nueva Comida"></input>
      <input name="Restablecer" type="reset" class="btn btn-primary" value="Restablecer"></input>
    </div>
  </div>
  </div>
  <input type="hidden" name="MM_insert" value="form_prod">
  
 </form>
 </div>

		
</div>
	
<hr>
	<?php include("../includes/footer_admin.php"); ?>
  
  <hr>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 


</script>
<script src="../validador/jquery-1.10.2.min.js"></script>
<script src="../validador/bootstrapValidator.js"></script>
<script src="../js/bootstrap.js"></script>
<script type="text/javascript">
</script>
</body>
</html>
<?php
mysql_free_result($DatosCategoria);
?>
