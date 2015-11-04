<?php
if (TRUE){
	$host = "localhost";
	$usuari = "root";
	$clau = "";
	$bd = "bd_intranet";
} else {
	$host = "mysql.hostinger.es";
	$usuari = "u394198823_zoopl";
	$clau = "adminamin";
	$bd = "";
}

//Iniciamos la sesión
session_start();
		
$con = mysqli_connect('localhost','root','','bd_intranet');
$sql = "SELECT users.*,resources.*,resourcestype.*,registers.*,estadoinfo.* FROM ((((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN registers ON resources.idResource=registers.idResource) INNER JOIN users ON users.idUser=registers.idUser) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado)";

if(!empty($_SESSION['usuario'])){		//Aqui introducimos lo que puede ver un usuario con una cuentra normal
	$privilegios=$_SESSION['usuario'];	//Guardamos la variable usuario en $privilegios para que no haya diferencias entre usuario y administrador en el resto del codigo
}else if(!empty($_SESSION['admin'])){ 	//Aqui introducimos lo que vera el administrador
	$privilegios=$_SESSION['admin'];	//Guardamos la variable admin en $privilegios para que no haya diferencias entre usuario y administrador en el resto del codigo
	?>
	<table border>
	<tr>
		<th>Usuario</th>
		<th>Recurso</th>
		<th>Fecha inicio</th>
		<th>Fecha fin</th>
	</tr>
	<?php
	$datos=mysqli_query($con,$sql);
        while($valor=mysqli_fetch_array($datos)){
		    echo "<tr>";
		    echo "<td>".$valor['nomUser']."</td>";
		    echo "<td>".$valor['nomR']."</td>";
		    echo "<td>".$valor['data_ini']."</td>";
		    if($valor['data_fin']!=NULL){
		    	echo "<td>".$valor['data_fin']."</td>";
			}else{
				echo "<td>En uso</td>";
			}
		    echo "</tr>";
		}
	echo "</table>";

}else{
	echo "no eres miembro";
}
	
?>
<!-- Esto podran verlo usuarios y administradores -->
<table border>
	<tr>
		<th>Recurso</th>
		<th>Fecha inicio</th>
		<th>Fecha fin</th>
	</tr>
	<?php
		$sql.=" WHERE nomUser='$privilegios'";		//mostramos las reservas del usuario logeado
			$datos=mysqli_query($con,$sql);
		        while($valor=mysqli_fetch_array($datos)){
				    echo "<tr>";
				    echo "<td>".$valor['nomR']."</td>";
				    echo "<td>".$valor['data_ini']."</td>";
				    if($valor['data_fin']!=NULL){
		    			echo "<td>".$valor['data_fin']."</td>";		//fecha de devolución
					}else{
						echo "<td>En uso</td>";			//Texto a mostrar en caso de que no se haya devuelto
					}
		   			echo "</tr>";
				}
		echo "</table>";
	echo "<center><a href='logout.php'>Logout</a></center>";
	?>