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
	<nav id="menu_gral">
  		<ul>
    	<li><a href="#"><?php
    		echo  $_SESSION['usuario'];
		?></a>
        <ul><!-- Segundo nivel desplegable -->
         <li><a href="logout.php">Logout</a></li>
        </ul>
    </li>
</nav>

		
		</div>
		<div class="header">
			<img src="images/logo_2.png">

		</div>
		<div class="header-cont"></div>
			<div id='cssmenu'>
				<ul>
   			<li class='active'><a href='#'><span>Reservar</span></a></li>
   			<li><a href='paginausuario_historial.php'><span>Historial</span></a></li>
			</ul>
			</div>  
		<div class="contenido">
			awdawdw
		</div>
		<div class="footer"></div>
	</body>
	<footer></footer>
</HTML>