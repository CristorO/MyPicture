<html>
	<head>
		<!-- de acuerdo al contenido de la variable "accion", escribimos el título -->
		<?php
			if ($_GET["accion"] == "alta")
				echo "<title>" . "Alta de registro" . "</title>";

			if ($_GET["accion"] == "baja")
				echo "<title>" . "Baja en la agenda" . "</title>";

			if ($_GET["accion"] == "modificacion")
				echo "<title>" . "Modificaci&oacute;n en agenda" . "</title>";
		?>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
		<link rel="stylesheet" href="../CSS/style_index.css">
	</head>

	<body>
		<div class = "navbar">
			<h1>My Picture</h1>
			<div>
				<a href="index.php">Inicio</a>
				<a href="fotos_admi.php">Fotos</a>
				<a href="fotos_abm.php?accion=alta">Agregar Foto</a>
				<a href="fotos_abm.php?accion=modificacion">Modificar Foto</a>
				<a href="fotos_abm.php?accion=baja">Eliminar foto</a>
				<a href="eventos_admi.php">Eventos</a>
			</div>
		</div>

		<br><br><br>

		<?php
			// Acá mostramos la pantalla de carga de ALTAS.
			if ($_GET["accion"] == "alta"){
				echo "<center>";

				echo "<h1 class='nombre'>Agregar Foto</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"fotos_abm.php\" METHOD=\"POST\" ENCTYPE=\"multipart/form-data\">";

					echo "<div class='mb-3'>";
					echo "<label for='formFile' class='form-label'>Imagen</label>" . "<input class='form-control' type='file' id=\"img\" name=\"img\">" . "<br>";
					echo"</div>";

					echo "Descripcion: " . "<INPUT TYPE=\"TEXT\" NAME=\"desc\">" . "<BR>";
					echo "<BR>";
					echo "<INPUT TYPE=\"submit\" NAME=\"OK\">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_alta\" href='fotos_abm.php?accion=alta'>";

				echo "</FORM>";

				echo "<br>";
				echo "<div class='row'>";
				
				$conn = mysqli_connect('localhost', 'root', '', 'p7');
				
				if (!$conn) {
				  die("La conexion fallo: " . mysqli_connect_error());
				}
				
				$sql = "SELECT img, descr FROM galeria";
				$resultado = mysqli_query($conn, $sql);
				if(mysqli_num_rows($resultado) > 0){
                    while($row = mysqli_fetch_array($resultado)) {
                        echo "<div class='card' style='width: 18rem;'>";
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['img']) . "'>";
                            echo "<div class='card-body'>";
                                echo "<p class='card-text'>" . $row['descr'] . "</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else{
                    echo "No se encontraron resultados";
                }
				
				echo "</div>";
				echo "</center>";

				exit();
			}
		?>



		<?php
			// Acá, en base a los datos recibidos (nombre, telefono, direccion, etc), hacemos el alta.
			if ($_POST["accion"] == "realizar_alta"){
				$image = $_FILES['img']['tmp_name'];
				$contenido = file_get_contents($image);

				include("sqli.php");

				$descr = $_POST["desc"];
				alta ($contenido, $descr);
			}
		?>

		

		<?php
			//Acá solicitamos el ID para poder modificar el registro.
			if ($_GET["accion"] == "modificacion")	{
				echo"<br><center>";
				echo "<h1 class='nombre'>Modificar una Foto</h1>";
				echo "<div class='row'>";
					$conn = mysqli_connect('localhost', 'root', '', 'p7');

					if (!$conn) {
						die("La conexion fallo: " . mysqli_connect_error());
					  }
					  
					  $sql = "SELECT id_img, img, descr FROM galeria";
					  $resultado = mysqli_query($conn, $sql);
					  if(mysqli_num_rows($resultado) > 0){
						  while($row = mysqli_fetch_array($resultado)) {
							  echo "<div class='card' style='width: 18rem;'>";
								  echo "<img src='data:image/jpeg;base64," . base64_encode($row['img']) . "'>";
								  echo "<div class='card-body'>";
										echo "<p class='card-text'>" . $row['descr'] . "</p>";
										echo "<form action=\"fotos_abm.php\" method=\"POST\">";
											echo "<input type='hidden' name='id' value='" . $row['id_img'] . "'>";

											echo "<input type='hidden' name='accion' value='datos_modificacion'>";
											echo "<button type='submit' class='btn btn-primary'>Modificar</button>";	
									echo "</form>";	
									echo "</div>";
							  echo "</div>";
						  }
					  } else{
						  echo "No se encontraron resultados";
					  }
				echo "</div>";
				echo "</center>";
				
				exit();
			}
		?>
		


		<?php
			// Acá, en base al ID recibido, pedimos los datos para MODIFICAR.
			if (isset($_POST["accion"]) && $_POST["accion"] == "datos_modificacion"){
				include("sqli.php");

				
				$conexion = Conectarse();

					if (!$conexion)
					{
						echo "<h1>Error al intentar conectar a BD</h1>";
						
						exit();
					}

				$id = $_POST["id"];
				$consulta = "SELECT * FROM galeria WHERE id_img = $id";

				echo $consulta . "<br>";

				$resultado = mysqli_query($conexion, $consulta);

				$fila = mysqli_fetch_array($resultado);

				if (!$fila)
				{
					echo "<h1>Registro inexistente</h1>";
				
					exit();
				}

				//cargo los datos del registro en variables para que sea más cómodo trabajar.

                $image = $fila["img"];
                $desc = $fila["descr"];

				   //liberamos memoria que ocupa la consulta...
				   mysqli_free_result($resultado);

				   //cerramos la conexión con el motor de BD
				   mysqli_close($conexion);

				/*
				ahora que teóricamente tengo los datos del registro que quiero modificar, muestro
				el formulario de carga.
				*/
            echo "<center>";
				echo "<form action=\"fotos_abm.php\" method=\"POST\" ENCTYPE=\"multipart/form-data\">";
					echo "<div class='card' style='width: 18rem;'>";
					echo"<input type='hidden' name='dbimg' value='" . base64_encode($image) . "'>";
						echo "<img src='data:image/jpeg;base64," . base64_encode($image) . "'>";
						echo "<div class='card-body'>";
							echo "<input class='card-text' name='desc' value='" . $desc ."'>";
							echo "<input type='hidden' class='card-text' name='id' value = '" . $id . "'>";
							
							echo "<input type='hidden' name='accion' value='realizar_modificacion'>";
							echo "<button type='submit' class='btn btn-primary'>Modificar</button>";
							
						echo "</div>";
					echo "</div>";

					echo "<div class='mb-3'>";
					echo "<label for='formFile' class='form-label'>Imagen</label>" . "<input class='form-control' type='file' id=\"img\" name=\"img\">" . "<br>";
					echo"</div>";
					
				echo "</form>";	
				echo "</center>";	
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la modificación.
			if ($_POST["accion"] == "realizar_modificacion")	{
				define('UPLOAD_ERR_OK', 0);
				$id = $_POST["id"];
                $descr = $_POST["desc"];

				if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name']) && $_FILES['img']['error'] == UPLOAD_ERR_OK){
					$contenido = file_get_contents($_FILES['img']['tmp_name']);
					echo "Se ingreso nueva imagen";
				} else{
					$contenido = base64_decode($_POST['dbimg']);
					echo "Se ingreso imagen ya almacenada";
				}
				include("sqli.php");
				modificacion($id, $contenido, $descr);
			}
		?>
		

		<?php
			// Acá mostramos la pantalla de carga de BAJAS.
			if ($_GET["accion"] == "baja")	{
				echo"<br><center>";
				echo "<h1 class='nombre'>Modificar una Foto</h1>";
				echo "<div class='row'>";
					$conn = mysqli_connect('localhost', 'root', '', 'p7');

					if (!$conn) {
						die("La conexion fallo: " . mysqli_connect_error());
					  }
					  
					  $sql = "SELECT id_img, img, descr FROM galeria";
					  $resultado = mysqli_query($conn, $sql);
					  if(mysqli_num_rows($resultado) > 0){
						  while($row = mysqli_fetch_array($resultado)) {
							  echo "<div class='card' style='width: 18rem;'>";
								  echo "<img src='data:image/jpeg;base64," . base64_encode($row['img']) . "'>";
								  echo "<div class='card-body'>";
										echo "<p class='card-text'>" . $row['descr'] . " " . $row['id_img'] . "</p>";
										echo "<form action=\"fotos_abm.php\" method=\"POST\">";
											echo "<input type='hidden' name='id' value='" . $row['id_img'] . "'>";

											echo "<input type='hidden' name='accion' value='realizar_baja'>";
											echo "<button type='submit' class='btn btn-primary'>Eliminar</button>";	
									echo "</form>";	
									echo "</div>";
							  echo "</div>";
						  }
					  } else{
						  echo "No se encontraron resultados";
					  }
				echo "</div>";
				echo "</center>";
				
				exit();
			}
		?>

		<?php
			// Acá, en base al ID recibido, hacemos la baja.
			if ($_POST["accion"] == "realizar_baja"){
				$id = $_POST["id"];
				
				include("sqli.php");
				baja($id);
			}
		?>
	</body>
</html>