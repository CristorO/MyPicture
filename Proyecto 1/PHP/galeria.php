<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos MyPicture</title>

    <style>
        .btn-primary.clicked{
            background-color: red;
        }
    </style>

    <link rel="stylesheet" href="../CSS/style_index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body>
    <div class = "navbar">
        <h1>My Picture</h1>
        <div>
            <a href="index.php">Home</a>
            <a href="eventos.php">Eventos</a>
            <a href="#">Galeria de fotos</a>
            <a href="pedidos.php">Pedidos</a>
            <a href="index.php#info">Contactos</a> 
            <a href="inicio_sesion_admi.php">Administrador</a>    
        </div>
    </div>

    <br><br><br>

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
                                echo "<a href='#' id='boton' onclick='boton(this)' class='btn btn-primary'>Reservar</a>";
                            echo "</div>";
                        echo "</div>";
                    }
                } else{
                    echo "No se encontraron resultados";
                }
            ?>
        </div>
    </center>

    <script>
        function boton(boton){
            var valorActual = boton.textContent;

            if(valorActual === "Reservar"){
                boton.style.backgroundColor = "red";
                boton.textContent = "Reservado";
            } else if (valorActual === "Reservado") {
                boton.style.backgroundColor = "rgba(13,110,253,255)";
                boton.textContent = "Reservar";
            }
        }
    </script>

    <br><br>
    
    <div id="info" class = "contacto">
        <table>
            <td style="margin-rigth: 5em;">
                <p>CORREO: mypicture@gmail.com</p>
                <br>
                <p>TELEFONO: +(591) 2146587</p>
                <br>
                <p>WHATSAPP: +(591) 7654321/ +(591) 7456123</p>
            </td>
            <td>
                <p>FACEBOOK: MyPicture</p>
                <br>
                <p>INSTAGRAM: Picturin</p>
                <br>
                <p>HORARIOS DE ATENCION: Lunes a Viernes 10:00 - 18:00</p>
            </td>
        </table>
    </div>
</body>
</html>