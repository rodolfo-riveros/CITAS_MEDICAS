<?php
require_once "login.php";
require_once "funciones.php";

session_start(); 

if (isset($_POST["email"]) && isset($_POST["password"])) {
	$conexion = new mysqli($hn, $un, $pw, $db,$port);
	if ($conexion->connect_error) {
		die("Fatal Error");
	}

	$correo=get_post($conexion,"email");
	$password=get_post($conexion, "password");
	$password=md5($password);

	$query = "SELECT * FROM usuario where correo='$correo' and password='$password'";
	$result = $conexion->query($query);
	if (!$result) die ("Falló el acceso a la base de datos");
	
	$rows = $result->num_rows;
	$usuario=$result->fetch_array();
	if ($rows) {
		$_SESSION["id"]=$usuario[0];
		$_SESSION["correo"]=$usuario[6];
		$_SESSION["password"]=$usuario[8];
	}
}

if (isset($_SESSION["id"])) {
	header("Location: admin.php");
	exit();
}
?>
<!doctype html>
<html lang='es'>
<head>
	<meta charset='UTF-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=1.0'>
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" >
</head>
<body class="bg-light">

<div class="container">
	<div class="row">
		<div class="col col-12">
			<h1>Iniciar Sessión</h1>
		</div>
		<div class="col col-12">
			<div class="card">
				<div class="card-body">
					<form action="index.php" method="post">
						<div class="form-group">
								<label for="perfil">Perfil</label>
								<select class="form-control" id="perfil" name="perfil">
									<option value="1">Estudiante</option>
									<option value="2">Administrativo</option>
								</select>
						</div>
						<div class="form-group">
							<label for="email">Email address</label>
							<input type="email" class="form-control" id="email" name="email">
						</div>
						<div class="form-group">
							<label for="pass">Password</label>
							<input type="password" class="form-control" id="pass"  name="password">
						</div>

						<button type="submit" class="btn btn-primary">Iniciar Sessión</button>
					
					</form>
				</div>
				<div class="card-footer">
					<p>¿Todavía no tienes una cuenta? <a href="registro.php">Registrarme</a>.</p>
					<p><a href="recuperar.php">Recuperar Contraseña</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>