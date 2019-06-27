<?php require_once('Connections/menu.php'); ?>
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

$maxRows_DatosMenu = 9;
$pageNum_DatosMenu = 0;
if (isset($_GET['pageNum_DatosMenu'])) {
  $pageNum_DatosMenu = $_GET['pageNum_DatosMenu'];
}
$startRow_DatosMenu = $pageNum_DatosMenu * $maxRows_DatosMenu;

mysql_select_db($database_menu, $menu);
$query_DatosMenu = "SELECT * FROM tbl_categorias WHERE st_cat = 1 ORDER BY tbl_categorias.nom_cat";
$query_limit_DatosMenu = sprintf("%s LIMIT %d, %d", $query_DatosMenu, $startRow_DatosMenu, $maxRows_DatosMenu);
$DatosMenu = mysql_query($query_limit_DatosMenu, $menu) or die(mysql_error());
$row_DatosMenu = mysql_fetch_assoc($DatosMenu);

if (isset($_GET['totalRows_DatosMenu'])) {
  $totalRows_DatosMenu = $_GET['totalRows_DatosMenu'];
} else {
  $all_DatosMenu = mysql_query($query_DatosMenu);
  $totalRows_DatosMenu = mysql_num_rows($all_DatosMenu);
}
$totalPages_DatosMenu = ceil($totalRows_DatosMenu/$maxRows_DatosMenu)-1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Menú del Restaurante</title>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/estilos.css" rel="stylesheet">
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
   
<div class="container">
 <h1 class="text-center">Menú del Restaurante</h1>
 
  <div class="row">
  <?php do { ?>
  <div class="col-sm-6 col-md-4">
  <div class="thumbnail"><br>

  <img style="height:200px; width:200px;" src="img/menu/<?php echo $row_DatosMenu['img_cat']; ?>" alt="..." class="img-circle img-responsive">
  <div class="caption">
  <h3 class="text-center titu_cat"> <?php echo $row_DatosMenu['nom_cat']; ?></h3>
 
  <p class="text-right"><a href="comida.php?idprod=<?php echo $row_DatosMenu['id_cat']; ?>" class="btn btn-info" role="button">Ver Menú</a> </p>
 </div>
 </div>
 </div>
  <?php } while ($row_DatosMenu = mysql_fetch_assoc($DatosMenu)); ?>
 </div>
 
  </div>
 </div>

  </div>
  <hr>
	<?php include("includes/footer.php"); ?>
  
  <hr>


</body>
</html>
<?php
mysql_free_result($DatosMenu);
?>
