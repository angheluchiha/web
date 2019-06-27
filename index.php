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

$maxRows_DatosMenuNuevos = 4;
$pageNum_DatosMenuNuevos = 0;
if (isset($_GET['pageNum_DatosMenuNuevos'])) {
  $pageNum_DatosMenuNuevos = $_GET['pageNum_DatosMenuNuevos'];
}
$startRow_DatosMenuNuevos = $pageNum_DatosMenuNuevos * $maxRows_DatosMenuNuevos;

mysql_select_db($database_menu, $menu);
$query_DatosMenuNuevos = "SELECT * FROM tbl_productos ORDER BY id_prod DESC";
$query_limit_DatosMenuNuevos = sprintf("%s LIMIT %d, %d", $query_DatosMenuNuevos, $startRow_DatosMenuNuevos, $maxRows_DatosMenuNuevos);
$DatosMenuNuevos = mysql_query($query_limit_DatosMenuNuevos, $menu) or die(mysql_error());
$row_DatosMenuNuevos = mysql_fetch_assoc($DatosMenuNuevos);

if (isset($_GET['totalRows_DatosMenuNuevos'])) {
  $totalRows_DatosMenuNuevos = $_GET['totalRows_DatosMenuNuevos'];
} else {
  $all_DatosMenuNuevos = mysql_query($query_DatosMenuNuevos);
  $totalRows_DatosMenuNuevos = mysql_num_rows($all_DatosMenuNuevos);
}
$totalPages_DatosMenuNuevos = ceil($totalRows_DatosMenuNuevos/$maxRows_DatosMenuNuevos)-1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Restaurante Lebanon House</title>

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
   
<div class="container">
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
	   <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner  img-circle" align="center">
    <div class="item active">
      <img src="img/slider/slider1.jpg" width="250px" height="250px" alt=""/> 
		  
    </div>

    <div class="item  img-circle" align="center">
       <img src="img/slider/slider2.jpg" width="250px" height="250px" >
		
    </div>

    <div class="item  img-circle" align="center">
     <img src="img/slider/slider3.jpg" width="250px" height="250px">
		
    </div>
	  
	  
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<div class="nuevo">
  <div align="center">Nuevo Comida incluida </div>
</div>
<div class="row"><br>

  <?php do { ?>
    
       <div class="col-sm-6 col-lg-3 prod_nuevo">
  <div class="thumbnail"><br>
<div class="badge" ><?php echo $row_DatosMenuNuevos['prec_prod']; ?> Bsf</div>
   <img style="height:200px; width:200px;"src="img/comida/<?php echo $row_DatosMenuNuevos['img_prod']; ?>" class="img-responsive img-circle img-rounded"><br>

   <div class="existencia" align="center" ><?php echo $row_DatosMenuNuevos['cant_prod']; ?> Unidades</div>
  <div class="caption">
  <h4 class="text-center titu_cat"> <?php echo $row_DatosMenuNuevos['nom_pro']; ?></h4>
 
 </div>
 </div>
 </div>
    <?php } while ($row_DatosMenuNuevos = mysql_fetch_assoc($DatosMenuNuevos)); ?>

</div>
</div>
  <hr>
	<?php include("includes/footer.php"); ?>
  
  <hr>


</body>
</html>
<?php
mysql_free_result($DatosMenuNuevos);
?>
