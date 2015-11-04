<!DOCTYPE html>
<html>
	<head>
		<title>  </title>
		<meta charset="UTF-8">
		<script type="text/javascript">
			function OnSelectionChange (select){
				var selectedOption = select.value;
				//alert ("The selected option is " + selectedOption);
				document.tipo_recurso.submit();
			}
		</script>
	</head>
	<body>
		<form name="tipo_recurso" action="formularis_definitiu.php" method="POST">
			<?php
				if (!isset($_REQUEST['recursos'])){
					$conn=mysqli_connect('localhost','root','','bd_intranet');
	                $consulta_Rtype="SELECT idRType, tipo FROM resourcestype";
	                $datos=mysqli_query($conn,$consulta_Rtype);
	        ?>
					<h2>Tipus de recurs:</h2>
					<select name="recursos" onchange="OnSelectionChange(this)">
			            <?php
			            	while($nom=mysqli_fetch_array($datos)){
			               		echo "<option value='$nom[idRType]' selected=$nom[12]>".utf8_encode($nom['tipo'])."</option>";
			               	}
			            ?>   	
		            </select>
		        <?php 
		        	$consulta_Resource="SELECT idResource, nomR FROM resources";
		            $datos_resources=mysqli_query($conn,$consulta_Resource);
		        ?>
		            <h2> Recurs: </h2>
		            <select name="recurso">
		            	<?php
		            		while($nombre=mysqli_fetch_array($datos_resources)){
			               		echo "<option value='$nombre[idResource]' selected=$nombre[18]>".utf8_encode($nombre['nomR'])."</option>";
			               	}
		            	?>
		        	</select>
		    <?php  
	            } else {
	            	$conn=mysqli_connect('localhost','root','','bd_intranet');
	            	$consulta_Rtype="SELECT idRType, tipo FROM resourcestype";
	                $datos=mysqli_query($conn,$consulta_Rtype);
	        ?>
		            <h2>Tipus de recurs:</h2>
					<select name="recursos" onchange="OnSelectionChange (this)">
			            <?php
			            	while($nom=mysqli_fetch_array($datos)){
			               		echo "<option value='$nom[idRType]'";
			               		if($_REQUEST['recursos']==$nom['idRType']) echo "selected";
			               		echo ">".utf8_encode($nom['tipo'])."</option>";
			               	}
			            ?>
		            </select>
		            <?php 
		        	$consulta_Resource="SELECT idResource, nomR, idRType FROM resources WHERE idRType=$_REQUEST[recursos]";
		            $datos_resources=mysqli_query($conn,$consulta_Resource);
		        	?>
		            <h2> Recurs: </h2>
		            <select name="recurso">
		            	<?php
		            		while($nombre=mysqli_fetch_array($datos_resources)){
			               		echo "<option value='$nombre[idRType]'>".utf8_encode($nombre['nomR'])."</option>";
			               	}
		            	?>
		        	</select>
	        <?php
	        	}
       		?>
       			

		</form>
	</body>
</html>