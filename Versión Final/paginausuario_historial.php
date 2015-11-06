<?php
	session_start();
?>
<!DOCTYPE HTML>
<HTML>
	<head>
		<title></title>
		<meta charset='utf-8'>
   		<meta http-equiv="X-UA-Compatible" content="IE=edge">
   		<meta name="viewport" content="width=device-width, initial-scale=1">
   		<link rel="stylesheet" href="css/menu.css">
   		<link href="css/paginausuario.css" rel="stylesheet" type="text/css">
   		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   		<script src="js/script.js"></script>
   		<link rel="stylesheet" href="css/nav.css">
   		
		
	</head>
	
	<body>
	<?php
if(!empty($_SESSION['usuario'])){		//Aqui introducimos lo que puede ver un usuario con una cuentra normal
	$privilegios=$_SESSION['usuario'];	//Guardamos la variable usuario en $privilegios para que no haya diferencias entre usuario y administrador en el resto del codigo
}else if(!empty($_SESSION['admin'])){ 	//Aqui introducimos lo que vera el administrador
	$privilegios=$_SESSION['admin'];	//Guardamos la variable admin en $privilegios para que no haya diferencias entre usuario y administrador en el resto del codigo
}	
?>
		<div class="header">
			<nav id="menu_gral">
		  		<ul>
			    	<li><a href="#"><?php
			    		echo  $privilegios;
						?></a>
        		<ul><!-- Segundo nivel desplegable -->
         			<li><a href="logout.php">Logout</a></li>
        		</ul>
    				</li>
			</nav>
			<img src="images/logo_2.png">
		</div>
		<div class="header-cont"></div>
			<div id='cssmenu'>
				<ul>
   			<li><a href='paginausuario_reservar.php'><span>Reservar</span></a></li>
   			<li class='active'><a href='#'><span>Historial</span></a></li>
			</ul>
			</div>  
		<div class="contenido">
			<center><?php include("registros.php"); ?></center>
		</div>
		<div class="footer"></div>
	</body>
	<footer></footer>
</HTML>