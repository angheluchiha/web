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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_cat")) {
  $updateSQL = sprintf("UPDATE tbl_categorias SET nom_cat=%s, img_cat=%s, st_cat=%s WHERE id_cat=%s",
                       GetSQLValueString($_POST['nom_cat'], "text"),
                       GetSQLValueString($_POST['img_cat'], "text"),
                       GetSQLValueString($_POST['st_cat'], "int"),
                       GetSQLValueString($_POST['id_cat'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "edit_cat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varCat_EditCategoria = "0";
if (isset($_GET["edit_ID"])) {
  $varCat_EditCategoria = $_GET["edit_ID"];
}
mysql_select_db($database_menu, $menu);
$query_EditCategoria = sprintf("SELECT * FROM tbl_categorias WHERE tbl_categorias.id_cat =%s", GetSQLValueString($varCat_EditCategoria, "int"));
$EditCategoria = mysql_query($query_EditCategoria, $menu) or die(mysql_error());
$row_EditCategoria = mysql_fetch_assoc($EditCategoria);
$totalRows_EditCategoria = mysql_num_rows($EditCategoria);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Categoria</title>

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
<h1 class="text-center">Editar Categoria</h1>
<p>&nbsp;</p>

<div class="col-sm-offset-3 col-sm-6">
 
 <form class="form-horizontal" name="form_cat" id="form_cat" action="<?php echo $editFormAction; ?>" method="POST">
  <div class="form-group">
  <div class="col-xs-12">
   
 <input class="form-control" type="text" name="nom_cat" id="nom_cat" placeholder="Nombre Categoria" value="<?php echo $row_EditCategoria['nom_cat']; ?>" required>
  </div>
  </div>
  
  <div class="form-group">
  <div class="col-xs-12">
 <input class="form-control" type="text" name="img_cat" id="img_cat" placeholder="Imagen Categoria" value="<?php echo $row_EditCategoria['img_cat']; ?>" onClick="javascript:CargarImagen();" style="cursor:pointer" required readonly></input>
 </div>
  </div>
  
    <div class="form-group">
  <div class="col-xs-12"><span id="spryselect1">
    <select class="form-control" name="st_cat" id="st_cat">
      <option value="-" <?php if (!(strcmp("-", $row_EditCategoria['st_cat']))) {echo "selected=\"selected\"";} ?>>Seleccione </option>
      <option value="1" <?php if (!(strcmp(1, $row_EditCategoria['st_cat']))) {echo "selected=\"selected\"";} ?>>Activo </option>
      <option value="0" <?php if (!(strcmp(0, $row_EditCategoria['st_cat']))) {echo "selected=\"selected\"";} ?>>Inactivo </option>
      >
    </select>
    <span class="selectInvalidMsg">Completa este campo.</span></span></div>
  </div>
  
  <div class="form-group">
  <div class="col-xs-12">
    <div align="center">
      <input class="btn btn-primary" type="submit" value="Actualizar"></input>
      
    </div>
  </div>
  </div>
  <input type="hidden" name="MM_insert" value="form_cat"></input>
  <input type="hidden" name="id_cat" id="id_cat" value="<?php echo $row_EditCategoria['id_cat']; ?>">
  <input type="hidden" name="MM_update" value="form_cat">
  </input>
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
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-", isRequired:false});
</script>
</body>
</html>
<?php
mysql_free_result($EditCategoria);
?>
