<link rel="stylesheet" href="css/tablareservas.css">
<!DOCTYPE html>
<html>
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
				$user=$_SESSION['usuario'];
			} elseif(!empty($_SESSION['admin'])) {		//sesion de un administrador
				$user=$_SESSION['admin'];
			} else {
				?>
				<p>No estas logeado</p>
				<?php
			}
			//if ((!isset($_SESSION['resRecurso'])) OR (!isset($_SESSION['anuRecurso'])))
				if(isset($_SESSION['resRecurso'])){
					$hoy = date("Y-m-d H:i:s");
					$conn=mysqli_connect('localhost','root','','bd_intranet');
					$sql="UPDATE resources SET idEstado = 2 WHERE resources.idResource = $_SESSION[resRecurso]";
					//echo $sql;
					//echo $_SESSION['resRecurso']."kjhsadkjfhksadjhfksajdfhksajdfh<br><br><br>";
					$sql_i="INSERT INTO registers ('idRegister', 'data_ini', 'data_fin', 'idResource', 'idUser') VALUES (NULL, '$hoy', NULL, '$_SESSION[resRecurso]', '$user')";
					$datos=mysqli_query($conn,$sql);
					$datos2=mysqli_query($conn,$sql_i);
					unset($_SESSION['resRecurso']);
					//echo $_SESSION['resRecurso']."SEGUNDO EEEEEEEEECHHHHHOOOOOO";
					echo '<script language="javascript">
						
						document.location=("paginausuario_reservar.php");
						alert("Tu reserva se ha confirmado");
						</script>';     	

					//echo "Tu reserva se ha confirmado.<br>";
					//echo "<a href='paginausuario_reservar.php'>Volver</a>";
				}elseif (isset($_SESSION['anuRecurso'])){
					$hoy = date("Y-m-d H:i:s");
					$conn=mysqli_connect('localhost','root','','bd_intranet');
					$sql="UPDATE resources SET idEstado = 1 WHERE resources.idResource = $_SESSION[anuRecurso]";
					//echo $sql;
					$sql_i="UPDATE registers SET 'data_fin' = '$hoy' WHERE registers.idRegister = $_SESSION[anuRecurso]";
					$datos=mysqli_query($conn,$sql);
					$datos2=mysqli_query($conn,$sql_i);
					unset($_SESSION['anuRecurso']);
					echo '<script language="javascript">
						
						document.location=("paginausuario_reservar.php");
						alert("Tu reserva se ha anulado");
						</script>'; 

					//echo "Tu reserva se ha anulado";
					//echo "<a href='paginausuario_reservar.php'>Volver</a>";
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
							//echo $id;
							$conn=mysqli_connect('localhost','root','','bd_intranet');
							$sql="SELECT resources.*, resourcestype.*, estadoinfo.* FROM ((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoInfo.idEstado) WHERE resources.idResource=".$id;
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