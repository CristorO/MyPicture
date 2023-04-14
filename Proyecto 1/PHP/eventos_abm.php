<html>
	<head>
		<!-- de acuerdo al contenido de la variable "accion", escribimos el título -->
		<?php
			if ($_GET["accion"] == "alta")
				echo "<title>" . "Alta de registro" . "</title>";

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
				<a href="#">Home</a>
				<a href="eventos_admi.php">Eventos</a>
				<a href="#">Agregar Evento</a>
				<a href="eventos_abm.php?accion=modificacion">Modificar Evento</a>
				<a href="fotos_admi.php">Galeria de fotos</a>
			</div>
		</div>
		<br><br><br>

		<?php
			// Acá mostramos la pantalla de carga de ALTAS.
			if ($_GET["accion"] == "alta"){
				echo "<center>";

				echo "<h1 class='nombre'>Agregar Evento</h1>";
				echo "<br>";
				echo "<FORM ACTION=\"eventos_abm.php\" METHOD=\"POST\" ENCTYPE=\"multipart/form-data\">";

					echo "<div class='mb-3'>";
					echo "<label for='formFile' class='form-label'>Imagen</label>" . "<input class='form-control' type='file' id=\"img\" name=\"img\">" . "<br>";
					echo"</div>";

					echo "Titulo: " . "<INPUT TYPE=\"TEXT\" NAME=\"titulo\">" . "<BR>";
					echo "<BR>";
					echo "Descripcion: " . "<INPUT TYPE=\"TEXT\" NAME=\"desc\">" . "<BR>";
					echo "<BR>";
					echo "<INPUT TYPE=\"submit\" NAME=\"OK\">";
					echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_alta\" href='eventos_abm.php?accion=alta'>";

				echo "</FORM>";

				echo "<br>";
				echo "<div class='row'>";
				
				$conn = mysqli_connect('localhost', 'root', '', 'p7');
				
				if (!$conn) {
				  die("La conexion fallo: " . mysqli_connect_error());
				}
				
				$sql = "SELECT img_evento, titulo, descr FROM eventos";
				$resultado = mysqli_query($conn, $sql);
				if(mysqli_num_rows($resultado) > 0){
                    while($row = mysqli_fetch_array($resultado)) {
                        echo "<div class='card' style='width: 18rem;'>";
                            echo "<img src='data:image/jpeg;base64," . base64_encode($row['img_evento']) . "'>";
                            echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row['titulo'] . "</h5>";
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
				
				include("sql.php");

				$titulo = $_POST["titulo"];
				$descr = $_POST["desc"];

				alta ($contenido, $titulo, $descr);	
			
			}
		?>

		

		<?php
			//Acá solicitamos el ID para poder modificar el registro.
			if ($_GET["accion"] == "modificacion")	{
				echo"<br><center>";
				echo "<h1 class='nombre'>Modificar un Evento</h1>";
				echo "<div class='row'>";
					$conn = mysqli_connect('localhost', 'root', '', 'p7');

					if (!$conn) {
						die("La conexion fallo: " . mysqli_connect_error());
					  }
					  
					  $sql = "SELECT id_evento, img_evento, titulo, descr FROM eventos";
					  $resultado = mysqli_query($conn, $sql);
					  if(mysqli_num_rows($resultado) > 0){
						  while($row = mysqli_fetch_array($resultado)) {
							  echo "<div class='card' style='width: 18rem;'>";
								  echo "<img src='data:image/jpeg;base64," . base64_encode($row['img_evento']) . "'>";
								  echo "<div class='card-body'>";
										echo "<h5 class='card-title'>" . $row['titulo'] . "</h5>";
										echo "<p class='card-text'>" . $row['descr'] . "</p>";
										echo "<form action=\"eventos_abm.php\" method=\"POST\">";
											echo "<input type='hidden' name='id' value='" . $row['id_evento'] . "'>";

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
				include("sql.php");

				
				$conexion = Conectarse();

					if (!$conexion)
					{
						echo "<h1>Error al intentar conectar a BD</h1>";
						
						exit();
					}

				$id = $_POST["id"];
				$consulta = "SELECT * FROM eventos WHERE id_evento = $id";

				echo $consulta . "<br>";

				$resultado = mysqli_query($conexion, $consulta);

				$fila = mysqli_fetch_array($resultado);

				if (!$fila)
				{
					echo "<h1>Registro inexistente</h1>";
				
					exit();
				}

				//cargo los datos del registro en variables para que sea más cómodo trabajar.

                $image = $fila["img_evento"];
                $titulo = $fila["titulo"];
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
				echo "<form action=\"eventos_abm.php\" method=\"POST\" ENCTYPE=\"multipart/form-data\">";
					echo "<div class='card' style='width: 18rem;'>";
					echo"<input type='hidden' name='dbimg' value='" . base64_encode($image) . "'>";
						echo "<img src='data:image/jpeg;base64," . base64_encode($image) . "'>";
						echo "<div class='card-body'>";
							echo "<input type='text' name='titulo' class='card-title' value='" . $titulo . "'>";
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
				$titulo = $_POST["titulo"];
                $descr = $_POST["desc"];

				if(isset($_FILES['img']['tmp_name']) && !empty($_FILES['img']['tmp_name']) && $_FILES['img']['error'] == UPLOAD_ERR_OK){
					$contenido = file_get_contents($_FILES['img']['tmp_name']);
					echo "Se ingreso nueva imagen";
				} else{
					$contenido = base64_decode($_POST['dbimg']);
					echo "Se ingreso imagen ya almacenada";
				}
				include("sql.php");
				modificacion($id, $contenido, $titulo, $descr);
			}
		?>
	</body>
</html>