<?php
require_once 'class_login/login.class.php';
//accedemos al método singleton que es quién crea la instancia
//de nuestra clase y así podemos acceder sin necesidad de
//crear nuevas instancias, lo que ahorra consumo de recursos
$nuevoSingleton = Login::singleton_login(); 
 
if(isset($_SESSION['nick']))
{
	$nick = $_SESSION['nick'];
	$password = $_SESSION['password'];
	//accedemos al método usuarios y los mostramos
	$usuario = $nuevoSingleton->login_users($nick,$password);
	
	if($usuario == TRUE)
	{

		header("Location:home.php");
	}else{

		header("Location:false.php");
	}
}else{
	echo("no isset");
}
	

?>