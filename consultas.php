<?php
if (TRUE){
	$host = "localhost";
	$usuari = "root";
	$clau = "";
	$bd = "bd_intranet";
} else {
	$host = "mysql.hostinger.es";
	$usuari = "u394198823_zoopl";
	$clau = "adminamin";
	$bd = "";
}

//variables a recibir
$envio = $_REQUEST['']; //variable que recibimos al filtrar
 
 //realizamos la conexión con mysql
$con = mysqli_connect($host, $usuari, $clau, $bd);


//Consulta de filtros
$sql = "SELECT users.*,resources.*,resourcesType.*,registers.*,estadosInfo.* FROM (((resourcesType INNER JOIN resources ON resourcesType.idRType=resources.idRType) 
INNER JOIN registers ON resources.idResource=registers.idResource) 
INNER JOIN users ON users.idUser=registers.idUser) 
INNER JOIN estadosInfo ON resources.idEstado=estadosInfo.idEstado)";

if (empty($envio)){
	$sql.=" ORDER BY idResources ASC"
	$datos=mysqli_query($con,$sql);

	while($recursos=mysqli_fetch_array($datos)){
		//echo "Recurso: ".utf8_encode($recursos['img'])."<br/>";
		echo "Recurso: ".utf8_encode($recursos['nomR'])."<br/>";
		echo "Recurso: ".utf8_encode($recursos['nomUser'])."<br/>";
		echo "Recurso: ".utf8_encode($recursos['nomEstado'])."<br/>";
		echo "Recurso: ".utf8_encode($recursos['data_ini'])."<br/>";
	}
}else{

}
?>