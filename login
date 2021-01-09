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
