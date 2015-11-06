<link rel="stylesheet" href="css/tablareservas.css">
<!DOCTYPE html>
<html>
	<head>
		<title>  </title>
		<meta charset="UTF-8">
		<!-- FUNCION DE JAVASCRIPT QUE SE ENCARGARA DE RECARGAR LA PAGINA CADA VEZ QUE MODIFIQUEMOS EL SELECT="tipo_recurso" -->
		<script type="text/javascript">
			function OnSelectionChange (select){
				//var selectedOption = select.value;
				//alert ("The selected option is " + selectedOption);
				document.formulario_reservas.submit();
			}
					
		</script>
	</head>
	<body>
<!-- DIV EN EL QUE SE METE TODO LO REFERENTE AL FORMULARIO (LOS 3 SELECTS I EL SUBMIT) -->
		<div id="desplegables">
			<!-- FORMULARIO CON LOS 3 SELECT -->
			<form name="formulario_reservas" action="paginausuario_reservar.php" method="POST">
				<!-- DENTRO DEL FORMULARIO SE AÑADE UN IF QUE COMPRUEVA SI LA VARIABLE DEL SELECT name="tiporecursos" EXISTE O NO -->
				<?php
					if (!isset($_REQUEST['tiporecursos'])){
						//EN EL CASO DE QUE NO EXISTA, EJECUTA EL SIGUIENTE CODIGO.
						//Conexion a la BBDD.
						$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
						//Almacenar la consulta SQL en una variable.
		                $consulta_Rtype="SELECT idRType, tipo FROM resourcestype";
		                //Almacenar resultado de consulta en un Array.
		                $datos=mysqli_query($conn,$consulta_Rtype);
		        ?>
						<div id="div_izq"><h3>Tipus de recurs:</h3>
						<!-- Creacion del primer SELECT name="tiporecursos" que ejecutara la funcion OnSelectionChange() declarada arriba -->
						<select name="tiporecursos" onchange="OnSelectionChange(this)">
				            <?php
				            	//Mostramos el contenido del Array, mostrando por defecto la opcion 12, que es Todos los tipos de recursos.
				            	while($nom=mysqli_fetch_array($datos)){
				               		echo "<option value='$nom[idRType]' selected=$nom[12]>".utf8_encode($nom['tipo'])."</option>";
				               	}
				            ?>   	
			            </select>
			        <!--
			        <?php 
			           	//$consulta_Resource="SELECT idResource, nomR FROM resources";
			            //$datos_resources=mysqli_query($conn,$consulta_Resource);
			        ?>
			            <h2> Recurs: </h2>
			             Creacion del segundo SELECT name="recurso" 
			            <select name="recurso">
			            	<option value="18" selected>Todos los recursos</option>
			            	
			            	<?php
			            		/*Mostramos el contenido del Array, que variara lo seleccionado en el primer SELECT
			            		while($nombre=mysqli_fetch_array($datos_resources)){
				               		echo "<option value='$nombre[idResource]' selected=$nombre[18]>".utf8_encode($nombre['nomR'])."</option>";
								}*/
			            	?>
			            	
			        	</select>
			        -->
			        <?php 
			        	$consulta_Estado="SELECT idEstado, nomEstado FROM estadoinfo";
			            $datos_estado=mysqli_query($conn,$consulta_Estado);
			        ?></div>
			        	<div id="div_cen"><h3> Estado: </h3>
			            <select name="estado">
			            	<?php
			            		while($nombres=mysqli_fetch_array($datos_estado)){
				               		echo "<option value='$nombres[idEstado]' selected=$nombres[4]>".utf8_encode($nombres['nomEstado'])."</option>";
				               	}
			            	?>
			        	</select>
			    <?php
		            } else {
		            	//EN EL CASO DE QUE SI EXISTA EJECUTA EL SIGUIENTE CODIGO.
		            	$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
		            	$consulta_Rtype="SELECT idRType, tipo FROM resourcestype";
						$datos=mysqli_query($conn,$consulta_Rtype);
		        ?></div>
			             <div id="div_izq"><h3>Tipus de recurs:</h3>
						<select name="tiporecursos" onchange="OnSelectionChange (this)">
				            <?php
				            	while($nom=mysqli_fetch_array($datos)){
				               		echo "<option value='$nom[idRType]'";
				               		if($_REQUEST['tiporecursos']==$nom['idRType']) echo "selected";
				               		echo ">".utf8_encode($nom['tipo'])."</option>";
				               	}
				            ?>
			            </select>
			            <!--
			            <?php 
				        	//$consulta_Resource="SELECT idResource, nomR, idRType FROM resources WHERE idRType=$_REQUEST[tiporecursos]";
				            //$datos_resources=mysqli_query($conn,$consulta_Resource);
			        	?>
			            <h2> Recurs: </h2>
			            <select name="recurso">
			            	<?php
			            		//while($nombre=mysqli_fetch_array($datos_resources)){
				               		//echo "<option value='$nombre[idRType]'>".utf8_encode($nombre['nomR'])."</option>";
				               	//}
			            	?>
			        	</select>
						-->
			        	<?php 
				        	$consulta_Estado="SELECT idEstado, nomEstado FROM estadoinfo";
				            $datos_estado=mysqli_query($conn,$consulta_Estado);
			        	?></div>
			        	<div id="div_cen"><h2> Estado: </h2>
			            <select name="estado">
			            	<?php
			            		while($nombres=mysqli_fetch_array($datos_estado)){
				               		echo "<option value='$nombres[idEstado]'";
				               		if($_REQUEST['estado']==$nombres['idEstado']) echo "selected";
				               		echo ">".utf8_encode($nombres['nomEstado'])."</option>";
				               	}
			            	?>
			        	</select>
		        <?php
		        	}
	       		?>
	       		<br></div>
	       		
	       		<div id="div_boton"><input type="submit" value="Filtrar"></div>
	       	</form>
        </div>


 <!-- DIV PARA TODO LO REFERENTE A CONSULTAS. -->
        <div>
        	<br>
        	<center><table class="mytable">
        		<tr>
        			<th>Tipo Recurso:</th>
        			<th>Recurso:</th>
        			<th>Estado:</th>
        			<th>Reservar:</th>
        		</tr>
		        	<?php
		        		if ((!isset($_REQUEST['tiporecursos'])) OR ($_REQUEST['tiporecursos']==12)){
			        		$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
					        if ((!isset($_REQUEST['estado'])) OR ($_REQUEST['estado']==4)){
					        	$sql="SELECT resources.*, resourcestype.*, estadoinfo.* FROM ((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado)";
					        	//echo $sql;
					        }else{
					        	$sql="SELECT resources.*, resourcestype.*, estadoinfo.* FROM ((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado) WHERE resources.idEstado=$_REQUEST[estado] OR resources.idEstado=3";
					        	//echo $sql;
					        }
					        //echo $sql;
					        $datos=mysqli_query($conn,$sql);
					        $num_filas = mysqli_num_rows($datos);
					        //echo "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA IMPRIMO NUM FILAS";
					       // echo $num_filas;
					        if ($num_filas!=0){
						        while($valor=mysqli_fetch_array($datos)){
								    echo "<tr>";
									    echo "<td>".$valor['tipo']."</td>";
									    echo "<td>".$valor['nomR']."</td>";
									    echo "<td>".$valor['nomEstado']."</td>";
									    if ($valor['nomEstado']=="Disponible"){
									    	echo "<td><a href=paginausuario_reservar2.php?idresource=".$valor['idResource'].">Reservar</a></td>";
									    } else {
									    	echo "<td><a href=paginausuario_reservar2.php?idresource=".$valor['idResource'].">Anular</a></td>";
									    }
								    	
								    echo "</tr>";
								}
							} else {
								echo "<tr>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
								echo "</tr>";
							}
						} else {
							//echo $_REQUEST['tiporecursos'];
							$conn=mysqli_connect('mysql.hostinger.es','u888001602_admin','1234567890','u888001602_intra');
							$sql="SELECT resources.*, resourcestype.*, estadoinfo.* FROM ((resourcestype INNER JOIN resources ON resourcestype.idRType=resources.idRType) INNER JOIN estadoinfo ON resources.idEstado=estadoinfo.idEstado)";
					        $sql.=" WHERE";
					        $sql.=" resources.idRType=$_REQUEST[tiporecursos]";
					        if ((!isset($_REQUEST['estado'])) OR ($_REQUEST['estado']==4)){
					        	
					        }else{
					        	$sql.= " AND resources.idEstado=$_REQUEST[estado]";
					        }
					        $datos=mysqli_query($conn,$sql);
					        //echo $sql;
					        $num_filas = mysqli_num_rows($datos);
					        if ($num_filas!=0){
						        while($valor=mysqli_fetch_array($datos)){
								    echo "<tr>";
									    echo "<td>".$valor['tipo']."</td>";
									    echo "<td>".$valor['nomR']."</td>";
									    echo "<td>".$valor['nomEstado']."</td>";
									    if ($valor['nomEstado']=="Disponible"){
									    	echo "<td><a href=paginausuario_reservar2.php?idresource=".$valor['idResource'].">Reservar</a></td>";
									    } else {
									    	echo "<td><a href=paginausuario_reservar2.php?idresource=".$valor['idResource'].">Anular</a></td>";
									    }
								    echo "</tr>";
								}
							} else {
								echo "<tr>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
									echo "<td>No se han encontrado resultados.</td>";
								echo "</tr>";
							}

						}
		        	?>
        	</table></center>
        </div>
	</body>
</html>