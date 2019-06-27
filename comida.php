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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_datoscomida = 9;
$pageNum_datoscomida = 0;
if (isset($_GET['pageNum_datoscomida'])) {
  $pageNum_datoscomida = $_GET['pageNum_datoscomida'];
}
$startRow_datoscomida = $pageNum_datoscomida * $maxRows_datoscomida;

$varcat_datoscomida = "0";
if (isset($_GET["idprod"])) {
  $varcat_datoscomida = $_GET["idprod"];
}
mysql_select_db($database_menu, $menu);
$query_datoscomida = sprintf("SELECT * FROM tbl_productos WHERE tbl_productos.id_cat_prod = %s", GetSQLValueString($varcat_datoscomida, "int"));
$query_limit_datoscomida = sprintf("%s LIMIT %d, %d", $query_datoscomida, $startRow_datoscomida, $maxRows_datoscomida);
$datoscomida = mysql_query($query_limit_datoscomida, $menu) or die(mysql_error());
$row_datoscomida = mysql_fetch_assoc($datoscomida);

if (isset($_GET['totalRows_datoscomida'])) {
  $totalRows_datoscomida = $_GET['totalRows_datoscomida'];
} else {
  $all_datoscomida = mysql_query($query_datoscomida);
  $totalRows_datoscomida = mysql_num_rows($all_datoscomida);
}
$totalPages_datoscomida = ceil($totalRows_datoscomida/$maxRows_datoscomida)-1;

$queryString_datoscomida = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_datoscomida") == false && 
        stristr($param, "totalRows_datoscomida") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_datoscomida = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_datoscomida = sprintf("&totalRows_datoscomida=%d%s", $totalRows_datoscomida, $queryString_datoscomida);
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
 <h1 class="text-center">Menú del Restaurante</h1>
 <?php if ($totalRows_datoscomida > 0) { // Show if recordset not empty ?>
  <div class="row">
    
    <?php do { ?>
      <div class="col-sm-7 col-md-3">
        <div class="thumbnail"><br>
          
          <img class="img-responsive" src="img/comida/<?php echo $row_datoscomida['img_prod']; ?>" alt="..." width="110" height="110" class="img-circle">
          <div class="caption">

            <h4 class="text-center titu_prod"><?php echo $row_datoscomida['nom_pro']; ?> </h4>
            <p><?php echo $row_datoscomida['min_desc_prod']; ?></p>
            <div class="row">
            
            <div class="col-xs-6 precio"><strong>Precio: </strong> <?php echo $row_datoscomida['prec_prod']; ?> BFS</div>
            <div class="col-xs-6 text-right existencia"><strong>Cantidad: </strong> <?php echo $row_datoscomida['cant_prod']; ?></div>
            </div><br>

            <p class="text-right"><a href="#" data-toggle="modal" data-target="#<?php echo $row_datoscomida['id_prod']; ?>" class="btn btn-block btn-info btn-lg" role="button">Detalle del Menú</a> </p>
            </div>
          </div>
      </div>
      
      <!-- modals datos-->
      <div id="<?php echo $row_datoscomida['id_prod']; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">
      
      <!-- modals content-->
       <div class="modal-content">
        <div class="modal-header">
        
         <button type="button" class="close" data-dismiss="modal">&times; </button>
          <h2 class="modal-title text-center mayusculas"><?php echo $row_datoscomida['nom_pro']; ?></h2>
           </div>
          
            <div class="modal-body">
                 <div class="row">
                      <div class="col-sm-6">
                      <center>
                      <div class="img_lg"> <img class="img-responsive img-circle" src="img/comida/<?php echo $row_datoscomida['img_prod']; ?>" width="266" height="189"> </div> 
                      </center>
                           </div>
                           <div class="col-sm-6">
                            <p class="text-justify">
			<?php echo $row_datoscomida['desc_pro']; ?>
            </p>
          
            <div class="col-xs-6 precio"><strong>Precio: </strong> <?php echo $row_datoscomida['prec_prod']; ?> BFS</div>
            <div class="col-xs-6 text-right existencia"><strong>Cantidad: </strong> <?php echo $row_datoscomida['cant_prod']; ?></div>
         
            
             </div>
              <div class="modal-footer">
             <center>  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar </button></center>
                           </div>
                      </div>
            
           

            
          
           
                </div>
                </div>
                  </div>
                   </div><!-- fin- content-->



      <?php } while ($row_datoscomida = mysql_fetch_assoc($datoscomida)); ?>
    
  </div>
  <?php } // Show if recordset not empty ?>
</div>
 </div>
  <?php if ($totalRows_datoscomida == 0) { // Show if recordset empty ?>
    <div class="alert alert-danger"> Aún no hemos publicado menu para esta categoria. </div>
    <?php } // Show if recordset empty ?>
</div>
    <div class="container text-center">
    <ul class="pagination pagination-lg">
     <?php if ($pageNum_datoscomida > 0) { // Show if not first page ?>
     <li class="page-item">
     <a class="page-link" href="<?php printf("%s?pageNum_datoscomida=%d%s", $currentPage, 0, $queryString_datoscomida); ?>" aria-label="Primero">
      
       <span aria-hidden="true">&laquo; </span>
       <span class="sr-only">Primero</span>
        </a>
         </li>
         <?php } // Show if not first page ?>
           <?php if ($pageNum_datoscomida > 0) { // Show if not first page ?>
          <li class="page-item">  <a class="page-link" href="<?php printf("%s?pageNum_datoscomida=%d%s", $currentPage, max(0, $pageNum_datoscomida - 1), $queryString_datoscomida); ?>">Anterior</a> </li>
           <?php } // Show if not first page ?>
            <?php if ($pageNum_datoscomida < $totalPages_datoscomida) { // Show if not last page ?>
          <li class="page-item"> <a class="page-link" href="<?php printf("%s?pageNum_datoscomida=%d%s", $currentPage, min($totalPages_datoscomida, $pageNum_datoscomida + 1), $queryString_datoscomida); ?>">Siguiente</a> </li>
 <?php } // Show if not last page ?>
 <?php if ($pageNum_datoscomida < $totalPages_datoscomida) { // Show if not last page ?>
		<li class="page-item">
        <a class="page-link" href="<?php printf("%s?pageNum_datoscomida=%d%s", $currentPage, $totalPages_datoscomida, $queryString_datoscomida); ?>"  href="#" aria-label="Último">
       
        <span aria-hidden="true">&raquo; </span>
       <span class="sr-only">Último</span>
        </a>
         </li>
          <?php } // Show if not last page ?>
         </ul>
      
    </div>
  <hr>
	<?php include("includes/footer.php"); ?>
  
  <hr>


</body>
</html>
<?php
mysql_free_result($datoscomida);
?>
