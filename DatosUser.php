<?php require_once('Connections/menu.php'); ?>
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

$MM_restrictGoTo = "index.php";
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

if((isset($_POST["update"])) && ($_POST["update"] == "eliminarimg")){
	if(isset($_POST['img'])){
		$img = $_POST['img'];
		
		unlink ("img/user/".$img);
	}
	
	$updateSQL = sprintf ("UPDATE tbl_user SET img_user=%s WHERE id_user=%s",
						GetSQLValueString($_POST['img_user'], "text"),
						GetSQLValueString($_POST['id_user'], "int"));
						
						
	mysql_select_db($database_menu, $menu);
	$Result2 = mysql_query($updateSQL, $menu) or die (mysql_error());
	
	$updateGoTo = "datosUser.php";
	if(isset($_SERVER['QUERY_STRING'])){
		$updateGoTo .=(strpos($updateGoTo,'?')) ? "&" : "?";
		$updateGoTo .= $_SERVER['QUERY_STRING'];
		}
		
		header(sprintf("Location: %s", $updateGoTo));
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

mysql_select_db($database_menu, $menu);
$query_telefono = "SELECT * FROM tbl_cod_telefonos";
$telefono = mysql_query($query_telefono, $menu) or die(mysql_error());
$row_telefono = mysql_fetch_assoc($telefono);
$totalRows_telefono = mysql_num_rows($telefono);

mysql_select_db($database_menu, $menu);
$query_DatosUsuario = "SELECT * FROM tbl_user";
$DatosUsuario = mysql_query($query_DatosUsuario, $menu) or die(mysql_error());
$row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysql_num_rows($DatosUsuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contacto del Restaurante</title>

<!-- Bootstrap -->
<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/estilo.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script>
function CargarImagen()
{
	self.name = 'opener';
	remote = open ('img_user.php', 'remote', 'width=500, height=450, location=no, scrollbars=yes, menubars=no, toolbars=no, rezisable=no, fullscreen=no, status=yes');
	remote.focus();
	}
</script>
</head>
<body>
	<?php include("includes/menu.php"); ?>
   

	<div class="container-fluid">
    <div class="row">
    <div class="col-sm-4">
    <div class="thumbnail">
    <?php 
	if ($row_DatosUsuario["img_user"] == ""){ ?>
		<img src="img/user/no-user.jpg" width="200" style="cursor:pointer" class="img-responsive img-circle img-thumbnail" onClick="javascript:CargarImagen(); " title="Ingresar Foto">
<?php }else{ ?>
		
	
    
    <a href="" class="close" data-toggle="modal" data-target="#eliminar_foto" title="Eliminar"><img src="img/logo/eliminar.jpg" width="32" height="32"></a>
      <img src="img/user/<?php echo $row_DatosUsuario["img_user"]; ?>" width="200" style="cursor:pointer" class="img-responsive img-circle img-thumbnail" onClick="javascript:CargarImagen(); ">
      <?php } ?>
      
       </div>
          <a href="" class="btn btn-warning btn-block">Suspender Cuenta</a>
     <a href="" class="btn btn-danger btn-block">Eliminar Cuenta</a>
    </div>
    
     <div class="col-sm-8">
     <h1 class="text-center">Datos Usuario</h1>
  <form class="form-horizontal" name="for_user" id="for_user" method="POST" action="<?php echo $editFormAction; ?>">

<div class="form-group">
<div class="col-xs-12 col-sm-6">

<input type="text" class="form-control" name="nom_user" id="nom_user" value="<?php echo $row_DatosUsuario["nom_user"]; ?>" placeholder="Nombre del Usuario" required></input>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="apell_user" id="apell_user" value="<?php echo $row_DatosUsuario["apell_user"]; ?>" placeholder="Apellido del Usuario" required></input>
</div>
</div>



<div class="form-group">
<div class="col-xs-12 col-sm-6">
<select class="form-control" name="cod_telefono_user" id="cod_telefono_user">
  <option value="-" <?php if (!(strcmp("-", $row_DatosUsuario['cod_telefono_user']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
  <?php
do {  
?>
  <option value="<?php echo $row_telefono['id_cod_telefono']?>"<?php if (!(strcmp($row_telefono['id_cod_telefono'], $row_DatosUsuario['cod_telefono_user']))) {echo "selected=\"selected\"";} ?>><?php echo $row_telefono['telefono']?></option>
  <?php
} while ($row_telefono = mysql_fetch_assoc($telefono));
  $rows = mysql_num_rows($telefono);
  if($rows > 0) {
      mysql_data_seek($telefono, 0);
	  $row_telefono = mysql_fetch_assoc($telefono);
  }
?>
</select>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="telefono_user" id="telefono_user" value="<?php echo $row_DatosUsuario["telefono_user"]; ?>" placeholder="telefono del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<select class="form-control" name="cod_telefono_local_user" id="cod_telefono_local_user">
  <option value="-"  <?php if (!(strcmp("-", $row_DatosUsuario['cod_telefono_local_user']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
  <?php
do {  
?>
  <option value="<?php echo $row_telefono['id_cod_telefono']?>"<?php if (!(strcmp($row_telefono['id_cod_telefono'], $row_DatosUsuario['cod_telefono_local_user']))) {echo "selected=\"selected\"";} ?>><?php echo $row_telefono['telefono']?></option>
  <?php
} while ($row_telefono = mysql_fetch_assoc($telefono));
  $rows = mysql_num_rows($telefono);
  if($rows > 0) {
      mysql_data_seek($telefono, 0);
	  $row_telefono = mysql_fetch_assoc($telefono);
  }
?>
</select>
</div>
<div class="col-xs-12 col-sm-6">
<input type="text" class="form-control" name="telefono_local_user" id="telefono_local_user" value="<?php echo $row_DatosUsuario["telefono_local_user"]; ?>" placeholder="telefono del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<input type="password" class="form-control" name="pass_user" id="pass_user"  value="" placeholder="Clave del Usuario" ></input>
</div>
<div class="col-xs-12 col-sm-6">
<input type="password" class="form-control" name="repass_user" id="repass_user" value="" placeholder="Repetir clave" ></input>
</div>
</div>


<div class="form-group">
<div class="col-md-12 text-center">
<input type="text" class="form-control" name="email_user" id="email_user" value="<?php echo $row_DatosUsuario["email_user"]; ?>" placeholder="Email del usuario" required readonly></input>
</div>
</div>

<div class="form-group">
<div class="col-md-12 text-center">
<textarea class="form-control" rows="4" type="text" name="dirrecion_user" id="email_user" value=""  placeholder="Direccion detallada del usuario" required><?php echo $row_DatosUsuario["dirrecion_user"]; ?></textarea>
</div>
</div>

<div class="form-group">
<div class="col-xs-12 col-sm-6">
<input type="hidden" class="form-control" name="img_user" id="img_user" value="<?php echo $row_DatosUsuario["img_user"]; ?>" placeholder="Imagen del Usuario" required></input>
</div>
</div>

<div class="form-group">
<div class="col-md-12 text-center">
<input type="submit" class="btn btn-success btn-lg" value="Guardar Cambios"></input>
</div>
</div>
<input type="hidden" name="id_user" value="<?php echo $row_DatosUsuario["id_user"]; ?>"> 
<input type="hidden" name="actualizar_datos" value="for_user">


  </form>
    </div>
    </div>
    </div>
<br>
<hr>
	<?php include("includes/footer.php"); ?>
  <hr>
  
  <div id="eliminar_foto" class="modal fade" role="dialog">
<div class="modal-dialog" style="max-width:350px">

<div class="modal-content text-left">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h3 class="modal-title text-center"><small>Mensaje de Confirmación</small></h3>
</div>

<div class="modal-body">
<p>Desea quitar su foto de perfil</p>
</div>

<div class="modal-footer">
<form class="form-horizontal" name="eliminarimg" action="datosUser.php" method="post">
<input type="hidden" name="imagen_usuario" value=""></input>
<input type="hidden" name="id_user" value="<?php echo $row_DatosUsuario['id_user']; ?>"></input>
<input type="hidden" name="img" value="<?php echo $row_DatosUsuario['img_user']; ?>"></input>
<button class="btn btn-default" data-dismiss="modal">Cancelar</button>
<input class="btn btn-success" type="submit" value="Aceptar"></input>
<input type="hidden" name="update" value="eliminarimg">
</form>
</div>
</div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#for_user').bootstrapValidator({
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
			
			  apell_user: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'Escriba su Apellido Completo.'
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
			
			telefono_user: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'Escriba su Teléfono.'
                    }
                    
                }
            },
			
				telefono_local_user: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'Escriba su Teléfono.'
                    }
                    
                }
            },
			
			dirrecion_user: {
                message: '',
                validators: {
                    notEmpty: {
                        message: 'Escriba su Dirreción.'
                    }
                    
                }
            },
			
			
            pass_user: {
                validators: {
                  
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
</body>
</html>
<?php
mysql_free_result($telefono);


?>
