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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form_cat")) {
  $insertSQL = sprintf("INSERT INTO tbl_categorias (nom_cat, img_cat, st_cat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['nom_cat'], "text"),
                       GetSQLValueString($_POST['img_cat'], "text"),
                       GetSQLValueString($_POST['st_cat'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($insertSQL, $menu) or die(mysql_error());

  $insertGoTo = "add_cat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_DatosCategorias = 8;
$pageNum_DatosCategorias = 0;
if (isset($_GET['pageNum_DatosCategorias'])) {
  $pageNum_DatosCategorias = $_GET['pageNum_DatosCategorias'];
}
$startRow_DatosCategorias = $pageNum_DatosCategorias * $maxRows_DatosCategorias;

mysql_select_db($database_menu, $menu);
$query_DatosCategorias = "SELECT * FROM tbl_categorias";
$query_limit_DatosCategorias = sprintf("%s LIMIT %d, %d", $query_DatosCategorias, $startRow_DatosCategorias, $maxRows_DatosCategorias);
$DatosCategorias = mysql_query($query_limit_DatosCategorias, $menu) or die(mysql_error());
$row_DatosCategorias = mysql_fetch_assoc($DatosCategorias);

if (isset($_GET['totalRows_DatosCategorias'])) {
  $totalRows_DatosCategorias = $_GET['totalRows_DatosCategorias'];
} else {
  $all_DatosCategorias = mysql_query($query_DatosCategorias);
  $totalRows_DatosCategorias = mysql_num_rows($all_DatosCategorias);
}
$totalPages_DatosCategorias = ceil($totalRows_DatosCategorias/$maxRows_DatosCategorias)-1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ingresar Categorias</title>

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
<h1 class="text-center">Ingresar Categorias</h1>
<div class="row">
   <div class="col-sm-4">
     <div align="right">
       <table class="table">
         <tr>
           <th scope="col">N°</th>
           <th scope="col">Nombre</th>
         </tr>
         
         <?php 
  $contador = 1;  
  ?>
         
         <?php do { ?>
          <tr>
            <td><?php echo $contador; ?></td>
            <td><?php echo $row_DatosCategorias["nom_cat"]; ?></td>
          </tr>
           
           
  <?php 
  $contador = $contador + 1
  ?>
           
          <?php } while ($row_DatosCategorias = mysql_fetch_assoc($DatosCategorias)); ?>
       </table>
       
       
     </div>
   </div>
   <div class="col-sm-8">
   

<div class="col-sm-offset-3 col-sm-6">
 
 <form class="form-horizontal" name="form_cat" id="form_cat" action="<?php echo $editFormAction; ?>" method="POST">
  <div class="form-group">
  <div class="col-xs-12">
   
 <input class="form-control" type="text" name="nom_cat" id="nom_cat" placeholder="Nombre Categoria" required>
  </div>
  </div>
  
  <div class="form-group">
  <div class="col-xs-12">
 <input class="form-control" type="text" name="img_cat" id="img_cat" placeholder="Imagen Categoria" onClick="javascript:CargarImagen();" required readonly></input>
 </div>
  </div>
  
    <div class="form-group">
  <div class="col-xs-12"><span id="spryselect1">
    <select class="form-control" name="st_cat" id="st_cat">
      <option value="-">Seleccione </option>
      <option value="1">Activo </option>
      <option value="0">Inactivo </option>
      >
    </select>
    <span class="selectInvalidMsg">Completa este campo.</span></span></div>
  </div>
  
  <div class="form-group">
  <div class="col-xs-12">
    <div align="center">
      <input class="btn btn-primary" type="submit" value="Enviar"></input>
      <input name="Restablecer" type="reset" class="btn btn-primary" value="Restablecer"></input>
    </div>
  </div>
  </div>
  <input type="hidden" name="MM_insert" value="form_cat"></input>
 </form>
 </div>
  </div>
   </div>
	


   
<div class="container">


		
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
mysql_free_result($DatosCategorias);
?>
