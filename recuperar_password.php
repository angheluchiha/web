<?php require_once('Connections/menu.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Recuperar Contraseña</title>

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
   <h1 class="text-center">Recuperar Contraseña</h1>
   <hr class="linea">
<div class="container">

<div class="col-sm-4 col-sm-offset-4">

<form class="form-horizontal" name="form_recuperar" id="form_recuperar" action="<?php echo $editFormAction; ?>" method="post">

  <div class="form-group">
<div class="col-xs-12">
<input type="text" class="form-control" name="email_user" id="email_user" placeholder="Email del Usuario" required></input>
</div>
</div>

  <div class="form-group">
<div class="col-xs-12">
<input type="password" class="form-control" name="pass_user" id="pass_user" placeholder="Contraseña del Usuario" required></input>
</div>
</div>

  <div class="form-group">
<div class="col-xs-12">
<input type="password" class="form-control" name="repass_user" id="repass_user" placeholder="Confirmar Contraseña del Usuario" required></input>
</div>
</div>

  <div class="form-group">
<div class="col-xs-12 text-center">
<input type="submit"  class="btn btn-success btn-lg" value="Recuperar"></input>
</div>
</div>
<input type="hidden" name="st_user" id="st_user" value="0">
  <input type="hidden" name="MM_update" value="form_recuperar">
 </form>
	</div>
		
  </div>
  <hr class="linea">
	<?php include("includes/footer.php"); ?>
  
  <script type="text/javascript">
$(document).ready(function() {
    $('#form_recuperar').bootstrapValidator({
        message: 'Valor Invalido',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
		fields: {
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


</html>
