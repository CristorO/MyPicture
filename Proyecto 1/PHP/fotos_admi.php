<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style_index.css">
</head>
<body>
    <div class = "navbar">
        <h1>My Picture</h1>
        <div>
            <a href="index.php">Inicio</a>
            <a href="#">Fotos</a>
            <a href="fotos_abm.php?accion=alta">Agregar Foto</a>
            <a href="fotos_abm.php?accion=modificacion">Modificar Foto</a>
            <a href="fotos_abm.php?accion=baja">Eliminar foto</a>
            <a href="eventos_admi.php">Eventos</a>
        </div>
    </div>

    <br><br><br><br>
    
    <center>
        <h1 class="nombre">Galeria</h1>
        <br>
        <div class="row">
        
            <?php
                $conn = mysqli_connect('localhost', 'root', '', 'p7');

                if(!$conn){
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
                                echo "<a href='#' class='btn btn-primary'>Reservar</a>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else{
                    echo "No se encontraron resultados";
                }
            ?>
        </div>
    </center>
    <br><br>
</body>
</html>