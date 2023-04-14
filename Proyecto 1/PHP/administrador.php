<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

    <link rel="stylesheet" href="../CSS/style_index.css">
</head>
<body>
    <div class = "navbar">
        <h1>My Picture</h1>
        <div>
            <a href="#">Home</a>
            <a href="eventos_admi.php">Eventos</a>
            <a href="fotos_admi.php">Administrar fotos</a>
            <a href="pedidos.php">Pedidos</a>
        </div>
    </div>

    <br><br><br><br>

    <center>
        <h1 class="nombre">Eventos</h1>
        <br>
        <div class="row">

            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        
            <?php
                $conn = mysqli_connect('localhost', 'root', '', 'p7');

                if(!$conn){
                    die("La conexion fallo: " . mysqli_connect_error());
                }

                $sql = "SELECT img_evento, titulo, descr FROM eventos";
                $resultado = mysqli_query($conn, $sql);
                if(mysqli_num_rows($resultado) > 0){
                    while($row = mysqli_fetch_array($resultado)) {
                        echo "<div class='card' style='width: 18rem;'>";
                            echo "<img src='" . $row['img_evento'] . "'>";
                            echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row['titulo'] . "</h5>";
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