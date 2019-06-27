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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email_user'])) {
  $loginUsername=$_POST['email_user'];
  $password=$_POST['pass_user'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "principal.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_menu, $menu);
  
  $LoginRS__query=sprintf("SELECT id_user, email_user, pass_user FROM tbl_user WHERE email_user=%s AND pass_user=%s AND st_user = 1 AND id_nivel_user != 1",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $menu) or die(mysql_error());
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	 
	$_SESSION['MM_id'] = $row_LoginRS["id_user"];	     

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
     ?>
	  
	  <div class="alert alert-danger" id="alertas">
		  <span class="glyphicon glyphicon-warning-sign"> </span> <strong>Correo</strong> y/o <strong>Contraseña</strong> son incorrectos.
	  </div>   
   
   <?php  // header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Iniciar Sesión</title>

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
<div class="panel panel-warning">
  <div class="panel-heading">
    <h4 class="text-center" style="text-transform: uppercase;">Ingresar a la Administración</h4>
  </div>
<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-sm-4" style="margin-top:50px;">
<div class="thumbnail">
<img src="../img/logo/sesion.jpg" class="img-responsive" width="200">

<form class="form-horizontal" name="for-login" id="for-login" method="POST" action="<?php echo $loginFormAction; ?>">
  <div class="form-group">
<div class="col-xs-12">

<input type="text" class="form-control" name="email_user" id="email_user" placeholder="Email del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 ">
<input type="password" class="form-control" name="pass_user" id="pass_user" placeholder="Clave del Usuario" required></input>
</div>
</div>



<div class="form-group">
<div class="col-md-12 text-center">

<input type="submit" class="btn btn-primary btn-lg" value="Inicio"></input>
</div>
</div>
</form>
</div>
</div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>

<script>
  $(document).ready(function(){  
   setTimeout(function(){
      $('#alertas').hide('fast');
   },2000);
 
 });
</script>

</body>
</html>