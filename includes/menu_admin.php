<?php require_once('../Connections/menu.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../_admin/index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../_admin/index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$varUser_DatosUser = "0";
if (isset($_SESSION["MM_id"])) {
  $varUser_DatosUser = $_SESSION["MM_id"];
}
mysql_select_db($database_menu, $menu);
$query_DatosUser = sprintf("SELECT * FROM tbl_user WHERE id_user = %s", GetSQLValueString($varUser_DatosUser, "int"));
$DatosUser = mysql_query($query_DatosUser, $menu) or die(mysql_error());
$row_DatosUser = mysql_fetch_assoc($DatosUser);
$totalRows_DatosUser = mysql_num_rows($DatosUser);
?>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1">
      <ul class="nav navbar-nav">
      
        <li><a href="principal.php">Inicio</a></li>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categorias<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="add_cat.php">Agregar</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="edit_cat.php">Editar</a></li>
        <li role="separator" class="divider"></li>
        
        <?php if($row_DatosUser['id_nivel_user'] == 3){?>
        <li><a href="delete_cat.php">Eliminar</a></li>
        <?php }else{?>
     <li><a href="#" data-toggle="modal" data-target="#privilegio">Eliminar</a></li>
        <?php }?>

         
         </ul>
         </li>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menú<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="../_admin/add_menu.php">Agregar</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="../_admin/edit_prod.php">Editar</a></li>
        <li role="separator" class="divider"></li>
        
         <?php if($row_DatosUser['id_nivel_user'] == 3){?>
        <li><a href="delete_prod.php">Eliminar</a></li>
         <?php }else{?>
     <li><a href="#" data-toggle="modal" data-target="#privilegio">Eliminar</a></li>
        <?php }?>
         
         </ul>
         </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
      <li><a href="datosUser.php">Bienvenido: <?php echo $row_DatosUser['nom_user']; ?></a></li>
		    <li><a href="<?php echo $logoutAction ?>">Cerrar Sesión</a></li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid --> 
</nav>

  <div id="privilegio" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times; </button>
            <h2 class="modal-title text-center mayuscula">Mensaje  </h2>
              </div>
                <div class="modal-body">
                Lo sentimos solo el administrador tiene privilegios de eliminar.
                  </div>
                    </div>
                      </div>
                        </div>

<?php
mysql_free_result($DatosUser);
?>
