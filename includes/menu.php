<?php require_once('Connections/menu.php'); ?>
<?php require_once('Connections/menu.php'); ?>
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
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="repetido.php";
  $loginUsername = $_POST['email_user'];
  $LoginRS__query = sprintf("SELECT email_user FROM tbl_user WHERE email_user=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_menu, $menu);
  $LoginRS=mysql_query($LoginRS__query, $menu) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

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



$varUser_DatosUsuario = "0";
if (isset($_SESSION['MM_id'])) {
  $varUser_DatosUsuario = $_SESSION['MM_id'];
}
mysql_select_db($database_menu, $menu);
$query_DatosUsuario = sprintf("SELECT * FROM tbl_user WHERE tbl_user.id_user = %s", GetSQLValueString($varUser_DatosUsuario, "int"));
$DatosUsuario = mysql_query($query_DatosUsuario, $menu) or die(mysql_error());
$row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysql_num_rows($DatosUsuario);

mysql_select_db($database_menu, $menu);
$query_Datos_telefono = "SELECT * FROM tbl_cod_telefonos";
$Datos_telefono = mysql_query($query_Datos_telefono, $menu) or die(mysql_error());
$row_Datos_telefono = mysql_fetch_assoc($Datos_telefono);
$totalRows_Datos_telefono = mysql_num_rows($Datos_telefono);
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
  $password=md5($_POST['pass_user']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "index.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_menu, $menu);
  
  $LoginRS__query=sprintf("SELECT id_user, email_user, pass_user FROM tbl_user WHERE email_user=%s AND pass_user=%s AND st_user != 0",
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
    header("Location: ". $MM_redirectLoginFailed );
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "for-registro")) {
  $insertSQL = sprintf("INSERT INTO tbl_user (nom_user, apell_user, email_user, pass_user, cod_telefono_user, telefono_user, cod_telefono_local_user, telefono_local_user, dirrecion_user) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nom_user'], "text"),
                       GetSQLValueString($_POST['apell_user'], "text"),
					    GetSQLValueString($_POST['email_user'], "text"),
                       GetSQLValueString(md5($_POST['pass_user']), "text"),
                       GetSQLValueString($_POST['cod_telefono_user'], "int"),
                       GetSQLValueString($_POST['telefono_user'], "int"),
                       GetSQLValueString($_POST['cod_telefono_local_user'], "int"),
                       GetSQLValueString($_POST['telefono_local_user'], "int"),
                       GetSQLValueString($_POST['dirrecion_user'], "text"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($insertSQL, $menu) or die(mysql_error());

  $insertGoTo = "nuevo_usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


if ((isset($_POST["actualizar_datos"])) && ($_POST["actualizar_datos"] == "for_user")) {
	
	mysql_select_db($database_menu, $menu);
	$query_ImgUser = sprintf("SELECT img_user FROM tbl_user WHERE tbl_user.id_user = ".$_POST['id_user']);
	$ImgUser = mysql_query($query_ImgUser, $menu) or die (mysql_error());
	$row_ImgUser = mysql_fetch_assoc($ImgUser);
	$totalRows_ImgUser = mysql_num_rows($ImgUser);
	
	$img = $row_ImgUser["img_user"];
	if ((isset($_POST["img_user"])) && ($_POST["img_user"]!= $img)) {
	unlink ("img/user/".$img);
	 }
	 
	 if ((isset($_POST["pass_user"])) && ($_POST["pass_user"]!= '' )) {
	
  $updateSQL = sprintf("UPDATE tbl_user SET nom_user=%s, apell_user=%s, email_user=%s, pass_user=%s, img_user=%s, cod_telefono_user=%s, telefono_user=%s, cod_telefono_local_user=%s, telefono_local_user=%s, dirrecion_user=%s WHERE id_user=%s",
                       GetSQLValueString($_POST['nom_user'], "text"),
                       GetSQLValueString($_POST['apell_user'], "text"),
                       GetSQLValueString($_POST['email_user'], "text"),
                       GetSQLValueString(md5($_POST['pass_user']), "text"),
                       GetSQLValueString($_POST['img_user'], "text"),
                       GetSQLValueString($_POST['cod_telefono_user'], "int"),
                       GetSQLValueString($_POST['telefono_user'], "int"),
                       GetSQLValueString($_POST['cod_telefono_local_user'], "int"),
                       GetSQLValueString($_POST['telefono_local_user'], "int"),
                       GetSQLValueString($_POST['dirrecion_user'], "text"),
                       GetSQLValueString($_POST['id_user'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "DatosUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

}else{
	
	 $updateSQL = sprintf("UPDATE tbl_user SET nom_user=%s, apell_user=%s, email_user=%s, img_user=%s, cod_telefono_user=%s, telefono_user=%s, cod_telefono_local_user=%s, telefono_local_user=%s, dirrecion_user=%s WHERE id_user=%s",
                       GetSQLValueString($_POST['nom_user'], "text"),
                       GetSQLValueString($_POST['apell_user'], "text"),
                       GetSQLValueString($_POST['email_user'], "text"),
                     
                       GetSQLValueString($_POST['img_user'], "text"),
                       GetSQLValueString($_POST['cod_telefono_user'], "int"),
                       GetSQLValueString($_POST['telefono_user'], "int"),
                       GetSQLValueString($_POST['cod_telefono_local_user'], "int"),
                       GetSQLValueString($_POST['telefono_local_user'], "int"),
                       GetSQLValueString($_POST['dirrecion_user'], "text"),
                       GetSQLValueString($_POST['id_user'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "DatosUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
	
	}
	
	$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_recuperar")) {
  $updateSQL = sprintf("UPDATE tbl_user SET pass_user=%s, st_user=%s WHERE email_user=%s",
  
                       GetSQLValueString(md5($_POST['pass_user']), "text"),
					   GetSQLValueString($_POST['st_user'], "int"),
                       GetSQLValueString($_POST['email_user'], "text"));
                   

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "index.php";
  
  header(sprintf("Location: %s", $updateGoTo));
}
?>


<div class="container-fluid">
<div class="row cabecera">
	<div class="col-xs-6 col-sm-4" >
    <img src="img/slider/logo.jpg" width="150" height="150" class="img-responsive img-circle" alt="" />
	</div>
	<div class="col-sm-4 visible-sm visible-md visible-lg telefono">
    Télefono de contacto:
    <br />
0426-385-0478
</div>
	<div class="col-xs-6 text-right col-sm-4" >
		
	  
	  <br>
	  <img src="img/logo/facebook.png" width="40" height="40" class=" img-circle"alt=""/>
		<img src="img/logo/instagram.jpg" width="40" height="40" class=" img-circle" alt=""/>
		<img src="img/logo/twitter.png" width="40" height="40" class=" img-circle" alt=""/>
	</div>
	</div>
</div>

<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1">
      <ul class="nav navbar-nav">
      
        <li><a href="index.php">Inicio</a></li>
		  <li><a href="nosotros.php">Nosotros</a></li>
		  <li><a href="menu.php">Menú</a></li>
		  	  <li><a href="contacto.php">Contacto</a></li>
       </ul>
      <ul class="nav navbar-nav navbar-right">
      
      <?php if ((isset($_SESSION['MM_Username'])) &&($_SESSION['MM_Username']!= NULL)){
      
    ?>
       
       
       <li><a href="DatosUser.php"><?php echo $row_DatosUsuario["nom_user"]; ?>  <?php echo $row_DatosUsuario["apell_user"]; ?></a></li>
		    <li><a href="<?php echo $logoutAction ?>">Cerrar Sesión</a></li>
            <?php }else{?>
               <li><a href="#" data-toggle="modal" data-target="#sesion-modal">Inicio de Sesiòn</a></li>
		    <li><a href="#" data-toggle="modal" data-target="#registro-modal">Registrarse</a></li>
              
             <?php }?>
        </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>

<div id="sesion-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times; </button>
            <h2 class="modal-title ">  </h2>
        </div>
                <div class="modal-body">
                
 <div class="panel panel-warning">
  <div class="panel-heading">
    <h4 class="text-center" style="text-transform: uppercase;">Iniciar Sesión</h4>
  </div>
  
<div class="panel-body">
<div class="thumbnail">
<img src="img/logo/sesion.jpg" class="img-responsive" width="200">

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
<input type="submit" class="btn btn-primary btn-lg" value="Acceder"></input>
</div>
</div>

</form>
</div>

<div class="form-group">
<div class="col-md-12 text-center">
<a href="recuperar_password.php"><p>Olvido su Contraseña?</p></a>
</div>
</div>

</div>
</div>

				</div>
    </div>
                      </div>
                        </div> 
                     
                        
                        
<div id="registro-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times; </button>
            <h2 class="modal-title ">  </h2>
        </div>
                <div class="modal-body">
                
 <div class="panel panel-warning">
  <div class="panel-heading">
    <h4 class="text-center" style="text-transform: uppercase;">Nuevo Usuario</h4>
  </div>
  
<div class="panel-body">
<div class="thumbnail">


<form class="form-horizontal" name="for-registro" id="for-registro" method="POST" action="<?php echo $editFormAction; ?>">

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="nom_user" id="nom_user" placeholder="Nombre del Usuario" required></input>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="apell_user" id="apell_user" placeholder="Apellido del Usuario" required></input>
</div>
</div>



<div class="form-group">
<div class="col-xs-12 col-sm-6">
<select class="form-control" name="cod_telefono_user" id="cod_telefono_user">
  <option value="-">Seleccione</option>
  <?php
do {  
?>
  <option value="<?php echo $row_Datos_telefono['id_cod_telefono']?>"><?php echo $row_Datos_telefono['telefono']?></option>
  <?php
} while ($row_Datos_telefono = mysql_fetch_assoc($Datos_telefono));
  $rows = mysql_num_rows($Datos_telefono);
  if($rows > 0) {
      mysql_data_seek($Datos_telefono, 0);
	  $row_Datos_telefono = mysql_fetch_assoc($Datos_telefono);
  }
?>
</select>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="telefono_user" id="telefono_user" placeholder="telefono del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<select class="form-control" name="cod_telefono_local_user" id="cod_telefono_local_user">
  <option value="-" >Seleccione</option>
  <?php
do {  
?>
  <option value="<?php echo $row_Datos_telefono['id_cod_telefono']?>"><?php echo $row_Datos_telefono['telefono']?></option>
  <?php
} while ($row_Datos_telefono = mysql_fetch_assoc($Datos_telefono));
  $rows = mysql_num_rows($Datos_telefono);
  if($rows > 0) {
      mysql_data_seek($Datos_telefono, 0);
	  $row_Datos_telefono = mysql_fetch_assoc($Datos_telefono);
  }
?>
</select>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="telefono_local_user" id="telefono_local_user" placeholder="telefono del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<input type="password" class="form-control" name="pass_user" id="pass_user" placeholder="Clave del Usuario" required></input>
</div>
<div class="col-xs-12 col-sm-6">
<input type="password" class="form-control" name="repass_user" id="repass_user" placeholder="Repetir clave" required></input>
</div>
</div>


<div class="form-group">
<div class="col-md-12 text-center">
<input type="text" class="form-control" name="email_user" id="email_user" placeholder="Email del usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-md-12 text-center">
<textarea class="form-control" rows="4" type="text" name="dirrecion_user" id="email_user"  placeholder="Direccion detallada del usuario" required></textarea>
</div>
</div>

<div class="form-group">
<div class="col-md-12 text-center">
<input type="submit" class="btn btn-danger btn-lg btn-block" value="Registrarse"></input>
</div>
</div>
<input type="hidden" name="MM_insert" value="for-registro" />

</form>
</div>
</div>
</div>

				</div>
    </div>
  </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="js/bootstrap.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#for-registro').bootstrapValidator({
        message: 'Valor Invalido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
            nom_user: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'Escriba su Nombre Completo.'
                    }
                    
                }
            },
            email_user: {
                validators: {
                    notEmpty: {
                        message: 'Escriba su email.'
                    },
                    emailAddress: {
                        message: 'Email invalido.'
                    }
                }
            },
            pass_user: {
                validators: {
                    notEmpty: {
                        message: 'Escriba su Contraseña.'
                    },
					stringLength: {
                        min: 6,
                        max: 20,
                        message: 'Debe contener min. 6 y max. 20 digitos.'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'No puede contener espacios en blanco.'
                    },
                    identical: {
                        field: 'repass_user',
                        message: 'Las contraseñas no coinciden.'
                    }
                }
            },
            repass_user: {
                validators: {
                    notEmpty: {
                        message: 'Confirme su Contraseña'
                    },
                    identical: {
                        field: 'pass_user',
                        message: 'Las contraseñas no coinciden.'
                    }
                }
            }
		}
    });
});
</script>
<script src="validador/jquery-1.10.2.min.js"></script>
<script src="validador/bootstrapValidator.js"></script>
<?php
mysql_free_result($DatosUsuario);

mysql_free_result($Datos_telefono);
?>
