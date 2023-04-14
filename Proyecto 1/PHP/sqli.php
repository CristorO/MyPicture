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

	function alta ($contImg, $descr){
		$conexion = Conectarse();

			if (!$conexion)	{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}

		$consulta = mysqli_prepare($conexion, 'INSERT INTO galeria (img, descr) VALUES (?, ?)');

		mysqli_stmt_bind_param($consulta, 'ss', $contImg, $descr);

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

		$consulta = mysqli_prepare($conexion, 'DELETE FROM galeria WHERE id_img = ?');

		mysqli_stmt_bind_param($consulta, 'i', $id);

		mysqli_stmt_execute($consulta);

		if(mysqli_stmt_execute($consulta)){
			echo "Se elimino correctamente";
		} else{
			echo "No se elimino";
		}

		mysqli_close($conexion);
	}



	function modificacion ($id, $contenido, $descr)	{
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede dar de alta. Error al conectar.</h1>";
				exit();
			}

		$consulta = mysqli_prepare($conexion, 'UPDATE galeria SET img=?, descr=? WHERE id_img = ?');

		mysqli_stmt_bind_param($consulta, 'ssi', $contenido, $descr, $id);

		mysqli_stmt_execute($consulta);

		if(mysqli_stmt_execute($consulta)){
			echo "Se agrego correctamente";
		} else{
			echo "No agrego correctamente";
		}

		mysqli_close($conexion);
	}

?>