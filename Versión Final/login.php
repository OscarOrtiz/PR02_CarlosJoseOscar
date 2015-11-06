<?php

/****************************************
$con = mysqli_connect($host, $usuari, $clau, $bd); 
/*caturamos nuestros datos que fueron enviados desde el formulario mediante el metodo POST
**y los almacenamos en variables.*/
$usuario = $_REQUEST["user"];   
$password = $_REQUEST["pass"];
$con = mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
//Consulta de mysql con la que indicamos que necesitamos que seleccione
$result = mysqli_query($con, "SELECT * FROM users WHERE nomUser = '$usuario'");
//Validamos si el nombre del usuario existe en la base de datos o es correcto
if($row = mysqli_fetch_array($result))
{     
//Si el usuario es correcto ahora validamos su contraseña
	if($row["password"] == $password){
	  	//Creamos sesión
	  	session_start();  
	  	if($row['privilegios']=="member"){
		 	 //Almacenamos el nombre de usuario en una variable de sesión usuario
			  $_SESSION['usuario'] = $usuario;
			  $_SESSION['idUser'] = $row['idUser'];
		  	//Redireccionamos a la pagina que verá el usuario
		  	
		  	header("Location: paginausuario_reservar.php");

		}else{
			$_SESSION['admin'] = $usuario;
			$_SESSION['idUser'] = $row['idUser'];
			//Redireccionamos a la pagina que verá el usuario
			
			header("Location: paginausuario_reservar.php");
		}  
	}else{
  	//En caso que la contraseña sea incorrecta enviamos un msj y redireccionamos a login.php
 	echo '<script language="javascript">
		alert("Contraseña incorrecta");
		document.location=("index.html");
		</script>';
	}
}else{
 //en caso que el nombre de administrador es incorrecto enviamos un msj y redireccionamos a login.php
	echo '<script language="javascript">
		alert("Usuario incorrecto");
		document.location=("index.html");
		</script>';     
        
}

//Mysqli_free_result() se usa para liberar la memoria empleada al realizar una consulta
mysqli_free_result($result);

/*Mysqli_close() se usa para cerrar la conexión a la Base de datos y es 
**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
**programar una aplicación que tendrá muchas visitas ;) .*/
mysqli_close($con);
?>