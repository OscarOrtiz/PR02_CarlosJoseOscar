<link rel="stylesheet" href="css/tablareservas.css">
<!DOCTYPE html>
<html>
<?php
	session_start();
?>
	<head>
		<title>  </title>
		<meta charset="UTF-8">
		<!-- FUNCION DE JAVASCRIPT QUE SE ENCARGARA DE RECARGAR LA PAGINA CADA VEZ QUE MODIFIQUEMOS EL SELECT="tipo_recurso" -->
		<script type="text/javascript">

		</script>
	</head>
	<body>
		<?php
			if(!empty($_SESSION['usuario'])) {	// Sesion de un usuario			
				$user=$_SESSION['idUser'];
			} elseif(!empty($_SESSION['admin'])) {		//sesion de un administrador
				$user=$_SESSION['idUser'];
			} else {
				?>
				<p>No estas logeado</p>
				<?php
			}
			//if ((!isset($_SESSION['resRecurso'])) OR (!isset($_SESSION['anuRecurso'])))
				if(isset($_SESSION['resRecurso'])){
					$hoy = date("Y-m-d H:i:s");
					$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
					$sql="UPDATE resources SET idEstado = 2 WHERE resources.idResource = $_SESSION[resRecurso]";
					//echo $sql;
					//echo $_SESSION['resRecurso']."kjhsadkjfhksadjhfksajdfhksajdfh<br><br><br>";
					$sql_i="INSERT INTO registers (idRegister, data_ini, data_fin, idResource, idUser) VALUES (NULL, '$hoy', NULL, '$_SESSION[resRecurso]', '$user')";
					echo $sql_i;
					$datos=mysqli_query($conn,$sql);
					$datos2=mysqli_query($conn,$sql_i);
					unset($_SESSION['resRecurso']);
					//echo $_SESSION['resRecurso']."SEGUNDO EEEEEEEEECHHHHHOOOOOO";
					echo '<script language="javascript">
						document.location=("paginausuario_reservar.php");
						alert("Tu reserva se ha confirmado");
						</script>';    
				}elseif (isset($_SESSION['anuRecurso'])){
					$hoy = date("Y-m-d H:i:s");
					$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
					$sql_o="SELECT * FROM registers WHERE idresource =$_SESSION[anuRecurso] AND data_fin IS NULL";
					$sql="UPDATE resources SET idEstado = 1 WHERE resources.idResource = $_SESSION[anuRecurso]";
					//echo $sql_i;
					$datos3=mysqli_query($conn,$sql_o);
					$datos=mysqli_query($conn,$sql);
					$valorcito=mysqli_fetch_array($datos3);
					$sql_i="UPDATE registers SET data_fin = '$hoy' WHERE registers.idRegister = $valorcito[idRegister]";
					$datos2=mysqli_query($conn,$sql_i);
					unset($_SESSION['anuRecurso']);
					//unset($_SESSION['anuRegister']);
					echo '<script language="javascript">
						
						document.location=("paginausuario_reservar.php");
						alert("Tu reserva se ha anulado");
						</script>'; 
				}else{
		?>	
			<form name="confirmacion_reservas" action="paginausuario_reservar2.php" method="GET">
				<center><table class="mytable">
					<tr>
						<th>Tipo Recurso:</th>
					    <th>Recurso:</th>
					    <th>Estado:</th>
					    <th>Operacion:</th>
					</tr>
					<?php
						//echo "$_REQUEST[nomR]";
						if (!isset($_REQUEST['idresource'])){
							echo "<td>Por favor, vuelve atras, ha sucedido un error.</td>";
							echo "<td>Por favor, vuelve atras, ha sucedido un error.</td>";
							echo "<td>Por favor, vuelve atras, ha sucedido un error.</td>";
							echo "<td>Por favor, vuelve atras, ha sucedido un error.</td>";
							echo "</tr></table><br><br>";
							echo "<a href=paginausuario_reservar.php>Volver</a>";

						}else{
							$id = $_REQUEST['idresource'];
							//echo $id."AQUIIIIIIIIIIIIIIIIIIII ESTA EL ID";
							//echo $id;
							$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
							//$sql="SELECT resources.*, resourcestype.*, estadoinfo.*, registres.* FROM (((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado)INNER JOIN registres ON registres.idRegistre=resources.idResource) WHERE resources.idResource=".$id;
							$sql="SELECT resources.*, resourcestype.*, estadoinfo.* FROM ((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado) WHERE resources.idResource=".$id;
							$datos=mysqli_query($conn,$sql);
							while($valor=mysqli_fetch_array($datos)){
							    echo "<tr>";
								    echo "<td>".$valor['tipo']."</td>";
								    echo "<td>".$valor['nomR']."</td>";
								    echo "<td>".$valor['nomEstado']."</td>";
								 
								if ($valor['nomEstado']=="Disponible"){
									$_SESSION['resRecurso']=$valor['idResource'];
							    	echo "<td><input type='submit' value='Reservar' name='reservar'></td>";
							    } else {
							    	$_SESSION['anuRecurso']=$valor['idResource'];
							    	//$_SESSION['anuRegistro']=$valor['idRegister'];
							    	echo "<td><input type='submit' value='Anular' name='anular'></td>";
						    	} 
						    echo "</tr>";     
							}
								
						}
					?>
				</table>
			</form>
		<?php
			
			}
		?>
	</body>
</html>