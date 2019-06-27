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

if((isset($_POST["update"])) && ($_POST["update"] == "eliminarimg")){
	if(isset($_POST['img'])){
		$img = $_POST['img'];
		
		unlink ("../img/user/".$img);
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
	
	

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form_edit")) {
	
	
	mysql_select_db($database_menu, $menu);
	$query_ImgUser = sprintf("SELECT img_user FROM tbl_user WHERE tbl_user.id_user = ".$_POST['id_user']);
	$ImgUser = mysql_query($query_ImgUser, $menu) or die (mysql_error());
	$row_ImgUser = mysql_fetch_assoc($ImgUser);
	$totalRows_ImgUser = mysql_num_rows($ImgUser);
	
	$img = $row_ImgUser["img_user"];
	unlink ("../img/user/".$img);
	
  $updateSQL = sprintf("UPDATE tbl_user SET nom_user=%s, email_user=%s, pass_user=%s, img_user=%s WHERE id_user=%s",
                       GetSQLValueString($_POST['nom_user'], "text"),
                       GetSQLValueString($_POST['email_user'], "text"),
                       GetSQLValueString($_POST['pass_user'], "text"),
                       GetSQLValueString($_POST['img_user'], "text"),
                       GetSQLValueString($_POST['id_user'], "int"));

  mysql_select_db($database_menu, $menu);
  $Result1 = mysql_query($updateSQL, $menu) or die(mysql_error());

  $updateGoTo = "datosUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Administración</title>

<!-- Bootstrap -->
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/estilos.css" rel="stylesheet">

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
	<?php include("../includes/menu_admin.php"); ?>
  
   
	


   
<div class="container">
 <div class="row">
 <div class="col-xs-12 col-sm-4 text-center">
  <center> 
  <?php 
  if($row_DatosUser['img_user'] == "") {
    ?>
    <img src="../img/user/no-user.jpg" width="200" style="cursor:pointer" class="img-responsive img-circle img-thumbnail" onClick="javascript:CargarImagen();">
<?php 
}else{
  
  ?>
  <div class="close" data-toggle="modal" data-target="#eliminar_foto" title="Eliminar">x
  
  </div>
  
  <img src="../img/user/<?php echo $row_DatosUser['img_user']; ?>" width="200" style="cursor:pointer" class="img-responsive img-circle img-thumbnail" onClick="javascript:CargarImagen(); ">
  <?php 
}
  
  ?>
  
  
   </center>
   </div>
 <div class="col-xs-12 col-sm-8">
 
 <form class="form-horizontal" name="form_edit" id="form_edit" method="POST" action="<?php echo $editFormAction; ?>">
 <div class="form-group">
 <div class="col-xs-12">
 <input type="text" class="form-control" name="nom_user" id="nom_user" required value="<?php echo $row_DatosUser['nom_user']; ?>"  placeholder="Nombre Completo">
 </div>
 </div>
 
 <div class="form-group">
 <div class="col-xs-12">
 <input type="text" class="form-control" name="email_user" id="email_user" required readonly value="<?php echo $row_DatosUser['email_user']; ?>" placeholder="Email del Usuario">
 </div>
 </div>
 
 
 <div class="form-group">
 <div class="col-xs-12">
 <input type="password" class="form-control" name="pass_user" id="pass_user" required value="<?php echo $row_DatosUser['pass_user']; ?>" placeholder="Contraseña">
 </div>
 </div>
 
 <div class="form-group">
 <div class="col-xs-12">
 <input type="password" class="form-control" name="pass_user2" id="pass_user2" required value="<?php echo $row_DatosUser['pass_user']; ?>" placeholder="Repetir contraseña">
 </div>
 </div>
 
 <div class="form-group">
 <div class="col-xs-12 text-right">
 <input type="submit" class="btn btn-success btn-lg" value="Actualizar Datos">
 </div>
 </div>
 
 <input type="hidden" class="form-control" name="img_user" id="img_user" value="<?php echo $row_DatosUser['img_user']; ?>">  <input type="hidden" class="form-control" name="id_user" id="id_user" value="<?php echo $row_DatosUser['id_user']; ?>">
  <input type="hidden" name="MM_update" value="form_edit">
 </form>
	
</div>
</div>
</div>		
</div>
	
<hr>
	<?php include("../includes/footer_admin.php"); ?>
  
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
<input type="hidden" name="id_user" value="<?php echo $row_DatosUser['id_user']; ?>"></input>
<input type="hidden" name="img" value="<?php echo $row_DatosUser['img_user']; ?>"></input>
<button class="btn btn-default" data-dismiss="modal">Cancelar</button>
<input class="btn btn-success" type="submit" value="Aceptar"></input>
<input type="hidden" name="update" value="eliminarimg">
</form>
</div>
</div>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="../js/jquery-1.11.3.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="../js/bootstrap.js"></script>



<script type="text/javascript">
$(document).ready(function() {
    $('#form_edit').bootstrapValidator({
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
                        field: 'pass_user2',
                        message: 'Las contraseñas no coinciden.'
                    }
                }
            },
            pass_user2: {
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
<script src="../validador/jquery-1.10.2.min.js"></script>
<script src="../validador/bootstrapValidator.js"></script>  
</body>
</html>
