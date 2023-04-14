<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        if ($_GET["accion"] == "pedido")
            echo "<title>" . "Baja en la agenda" . "</title>";
    ?>
		<link rel="stylesheet" href="../CSS/style_index.css">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido realizado</title>
</head>
<body>
<div class = "navbar" >
        <img class="logo" src="../IMG/UCB-logo-lapaz.png">
        <a href="pedidos.php?accion=baja">Volver</a>
    </div>
    <br><br><br>
    <?php
        // Acá mostramos la pantalla de carga de BAJAS.
        if ($_GET["accion"] == "pedido")	{
            echo	"<br><center>";		
            echo	"<table BORDER=5 CELLSPACING=1 CELLPADDING=1 bordercolor=darkblue>";
            echo	"<TR>";
            echo	"<TD><b><font color=\"blue\">&nbsp;id sillon&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Modelo&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Marca&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Precio&nbsp;</font></b></TD>";
            echo	"</TR>";
                $conn = mysqli_connect('localhost', 'root', '', 'p5');

                if(!$conn){
                    die("La conexion fallo: " . mysqli_connect_error());
                }

                $sql = "SELECT id_sillon, modelo, marca, precio FROM info_sillon";
                $resultado = mysqli_query($conn, $sql);
                if(mysqli_num_rows($resultado) > 0){
                    while($row = mysqli_fetch_array($resultado)) {
                        echo "<TR>";
                        echo "<TD>&nbsp;" . $row["id_sillon"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["modelo"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["marca"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["precio"] . "</TD>";
                        echo "</TR>";
                    }
                } else{
                    echo "No se encontraron resultados";
                }
            echo 	"</table>";
                    
            echo "<h1><font color=\"blue\">Pedir un Producto</font></h1>";
            echo "<br>";
            echo "<FORM ACTION=\"realizar_pedido.php\" METHOD=\"GET\">";
                echo "id_sillon: " . "<INPUT TYPE=\"TEXT\" NAME=\"txtId\">" . "<BR><br>";
                echo "<INPUT TYPE=\"submit\" NAME=\"OK\">";
                echo "<INPUT TYPE=\"hidden\" NAME=\"accion\" VALUE=\"realizar_pedido\">";
            echo "</FORM>";
            echo"</center>";
            
            
            
            exit();
        }
    ?>

    <?php
        // Acá, en base al ID recibido, hacemos la baja.
        if ($_GET["accion"] == "realizar_pedido")
        {
            include("sql.php");
            
            $id = $_GET["txtId"];
            
            pedido($id);
        }
    ?>
</body>
</html>

<?php
    function pedido ($id)
    {
		$conexion = Conectarse();

			if (!$conexion)
			{
				echo "<h1>No se puede solicitar este producto. Error al conectar.</h1>";
				exit();
			}

		//Añadir pedido
        $sql="SELECT precio FROM info_sillon WHERE id_sillon=$id;";
        $res=mysqli_query($conexion, $sql);
        $fila=mysqli_fetch_row($res);
        $precio = $fila[0];
		$consultai = "INSERT INTO info_venta (sillon, precio, costo_envio) VALUES ('$id','$precio', 50)";
		$resultadoi=mysqli_query($conexion, $consultai);

		// NO poner comillas simples en nombre de tabla, ni de campos, sólo en valores alfanuméricos.
		$consultad = "DELETE FROM info_sillon WHERE id_sillon = $id;";

		echo	"<br><br><br><br><table BORDER=5 CELLSPACING=1 CELLPADDING=1 bordercolor=darkblue>";
            echo	"<TR>";
            echo	"<TD><b><font color=\"blue\">&nbsp;id venta&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Sillon&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Precio&nbsp;</font></b></TD>";
            echo	"<TD><b><font color=\"blue\">&nbsp;Costo de envio&nbsp;</font></b></TD>";
            echo	"</TR>";
                $conn = mysqli_connect('localhost', 'root', '', 'p5');

                if(!$conn){
                    die("La conexion fallo: " . mysqli_connect_error());
                }

                $sql = "SELECT id_venta, sillon, precio, costo_envio FROM info_venta WHERE sillon=$id;";
                $resultado = mysqli_query($conn, $sql);
                if(mysqli_num_rows($resultado) > 0){
                    while($row = mysqli_fetch_array($resultado)) {
                        echo "<TR>";
                        echo "<TD>&nbsp;" . $row["id_venta"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["sillon"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["precio"] . "</TD>";
                        echo "<TD>&nbsp;" . $row["costo_envio"] . "</TD>";
                        echo "</TR>";
                    }
                } else{
                    echo "No se encontraron resultados";
                }
            echo 	"</table>";

		$resultado=mysqli_query($conexion, $consultad);

		//echo "Resultado de la operaci&oacute;n: " . $resultado;

			//cerramos la conexión con el motor de BD
			mysqli_close($conexion);

	}
?>