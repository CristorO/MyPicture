<?php
	function Conectarse(){//inttroducimos los datos de  host que son "Server", "usuario" y "contraseña" 
		if (!($link=mysqli_connect("localhost", "root", "", "p7")))//aca hay que introducir los datos que especifique arriba!!!
		{
			return 0;
		}
		if (!mysqli_select_db($link, "p7"))	{
			return 0;
		}
		return $link;
	}

	//--------------------------------------------------------------------------------------------------------------------

	function alta ($contImg, $titulo, $descr){
		$conexion = Conectarse();

			if (!$conexion)	{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}

		$consulta = mysqli_prepare($conexion, 'INSERT INTO eventos (img_evento, titulo, descr) VALUES (?, ?, ?)');

		mysqli_stmt_bind_param($consulta, 'sss', $contImg, $titulo, $descr);

		mysqli_stmt_execute($consulta);

		mysqli_close($conexion);
	}

	//-------------------------------------------------------------------------------------------------------------------

	function baja ($id)
	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de baja. Error al conectar.</h1>";
				exit();
			}

		// NO poner comillas simples en nombre de tabla, ni de campos, sólo en valores alfanuméricos.
		$consulta = "DELETE FROM info_sillon WHERE id_sillon = $id";

		echo $consulta . "<BR>";

		$resultado=mysqli_query($conexion, $consulta);

		//echo "Resultado de la operaci&oacute;n: " . $resultado;

			//cerramos la conexión con el motor de BD
			mysqli_close($conexion);

	}



	function modificacion ($id, $contenido, $titulo, $descr)	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}

		$consulta = mysqli_prepare($conexion, 'UPDATE eventos SET img_evento=?, titulo=?,  descr=? WHERE id_evento = ?');

		mysqli_stmt_bind_param($consulta, 'sssi', $contenido, $titulo, $descr, $id);

		mysqli_stmt_execute($consulta);

		if(mysqli_stmt_execute($consulta)){
			echo "Se agrego correctamente";
		} else{
			echo "No agrego correctamente";
		}

		mysqli_close($conexion);
	}

?>