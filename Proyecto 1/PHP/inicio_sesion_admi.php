<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style_is.css">
    <title>Inicio Sesion</title>
</head>
<body>
    <div class="contenedor-isp">
        <img src="../IMG/admi.png" alt="user-login">
        <p class="text">Inicio Sesión</p>
        <p class="text">Administrador</p>
        <form method="POST" class="form-isp">
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <input type="password" name="password" id="password" placeholder="Contraseña">
            <a style="text-decoration: none;">
                <button id="btnEnviar" name="btnEnviar" type="submit" value="Enviar" class="boton-pac">
                    Iniciar Sesión
                </button>
            </a>
            
            <p class="or">o</p>

            <a href="index.php" style="text-decoration: none;">
                <button class="boton-login" type=button>
                    Volver
                </button>
            </a>
        </form>
    </div>
</body>
</html>

<?php
	// Conexión con la base de datos
	if(isset($_POST['btnEnviar'])) {
		$conexion = mysqli_connect('localhost', 'root', '', 'p7');

		$usuario = $_POST['usuario'];
		$password = $_POST['password'];	

		// SELECT 

		$sql = "SELECT * FROM admin";
		$result = mysqli_query($conexion, $sql);

		$usuario_registrado = false;
		$password_correcta = false;

		while($mostrar = mysqli_fetch_array($result)){
			if($usuario == $mostrar['usuario']){
				$usuario_registrado = true;
				if($password == $mostrar['pass']){
					$password_correcta = true;
				} else {
					$password_correcta = false;
				}
			}
		}

		if($password_correcta){
			header('Location: eventos_admi.php');
		}

		if($usuario_registrado && !$password_correcta){
			?>
			<script>
				alert("Contraseña incorrecta");
			</script>
			<?php
		}

		if(!$usuario_registrado && !$password_correcta){
			?>
			<script>
				alert("Usuario no registrado");
			</script>
			<?php
		}
	}
?>