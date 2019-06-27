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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_DatosProductos = 10;
$pageNum_DatosProductos = 0;
if (isset($_GET['pageNum_DatosProductos'])) {
  $pageNum_DatosProductos = $_GET['pageNum_DatosProductos'];
}
$startRow_DatosProductos = $pageNum_DatosProductos * $maxRows_DatosProductos;

mysql_select_db($database_menu, $menu);
$query_DatosProductos = "SELECT * FROM tbl_productos, tbl_categorias WHERE tbl_productos.id_cat_prod = tbl_categorias.id_cat";
$query_limit_DatosProductos = sprintf("%s LIMIT %d, %d", $query_DatosProductos, $startRow_DatosProductos, $maxRows_DatosProductos);
$DatosProductos = mysql_query($query_limit_DatosProductos, $menu) or die(mysql_error());
$row_DatosProductos = mysql_fetch_assoc($DatosProductos);

if (isset($_GET['totalRows_DatosProductos'])) {
  $totalRows_DatosProductos = $_GET['totalRows_DatosProductos'];
} else {
  $all_DatosProductos = mysql_query($query_DatosProductos);
  $totalRows_DatosProductos = mysql_num_rows($all_DatosProductos);
}
$totalPages_DatosProductos = ceil($totalRows_DatosProductos/$maxRows_DatosProductos)-1;

$queryString_DatosProductos = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_DatosProductos") == false && 
        stristr($param, "totalRows_DatosProductos") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_DatosProductos = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_DatosProductos = sprintf("&totalRows_DatosProductos=%d%s", $totalRows_DatosProductos, $queryString_DatosProductos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Eliminar Categorias</title>

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


</head>
<body>
	<?php include("../includes/menu_admin.php"); ?>
<div class="container">
  <h1 class="text-center">Eliminar Productos </h1>
  <div class="table-responsive text-center">
  <table class="table table-hover">
  <tbody>
  <tr bgcolor="#999999">
    <th scope="col">N°</h1></h1></th>
    <th scope="col">Imagen</th>
    <th scope="col">Nombre</th>
     <th scope="col">Precio</th>
      <th scope="col">Cantidad</th>
         <th scope="col">Categoria</th>
    <th scope="col">Acciones</th>
  </tr>
  
  <?php 
  $contador = 1;
  ?>
  
  <?php do { ?>
  <tr>
    <td><?php echo $contador ?></td>
    <td><img src="../img/comida/<?php echo $row_DatosProductos['img_prod']; ?>" width="80"></td>
    <td><?php echo $row_DatosProductos['nom_pro']; ?></td>
    <td><?php echo $row_DatosProductos['prec_prod']; ?> BFS</td>
    <td><?php echo $row_DatosProductos['cant_prod']; ?> Unidades</td>
     <td><?php echo $row_DatosProductos['nom_cat']; ?> </td>
    
    <td>
      <a onClick="return confirm('¿Estas seguro(a) de eliminar el producto <?php echo $row_DatosProductos['nom_pro']; ?> \n\n P.D si lo elimina no lo podra recuperar.');" href="delet_prod2.php?delet_ID=<?php echo $row_DatosProductos['id_prod']; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>  Eliminar</a>
    </td>
  </tr>
  
  <?php 
  $contador = $contador + 1
  ?>
  
  <?php } while ($row_DatosProductos = mysql_fetch_assoc($DatosProductos)); ?>
  </tbody>
</table>
<div class="pager">
  <?php if ($pageNum_DatosProductos > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_DatosProductos=%d%s", $currentPage, 0, $queryString_DatosProductos); ?>">Primero</a>
  <?php } // Show if not first page ?>
  
  <?php if ($pageNum_DatosProductos > 0) { // Show if not first page ?>
  <a href="<?php printf("%s?pageNum_DatosProductos=%d%s", $currentPage, max(0, $pageNum_DatosProductos - 1), $queryString_DatosProductos); ?>">Anterior</a>
  <?php } // Show if not first page ?>
  
  <?php if ($pageNum_DatosProductos < $totalPages_DatosProductos) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_DatosProductos=%d%s", $currentPage, min($totalPages_DatosProductos, $pageNum_DatosProductos + 1), $queryString_DatosProductos); ?>">Siguiente</a>
  <?php } // Show if not last page ?>
  
  <?php if ($pageNum_DatosProductos < $totalPages_DatosProductos) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_DatosProductos=%d%s", $currentPage, $totalPages_DatosProductos, $queryString_DatosProductos); ?>">Último</a>
  <?php } // Show if not last page ?>
  
</div>


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
mysql_free_result($DatosProductos);
?>
