<?php
session_start();
require_once "../config/db_connection.php";

if ($_POST["type"] == "Consulta_usuario") {
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);

        $sql = "SELECT 
        * 
        FROM usuarios 
        WHERE correo_us='$username'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['pass'])) {
                // Iniciar sesión y guardar variables
                $_SESSION['user_id'] = $row['id_usuario'];
                $_SESSION['username'] = $row['correo_us'];
                $_SESSION['nombre'] = $row['nombre_us'];
                $_SESSION['apellido'] = $row['apellido_us'];
                echo "Login exitoso";
            } else {
                echo "Usuario o contraseña incorrectos";
            }
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    }
}



if ($_POST["type"] == "registrar_usuario") {
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['company'])) {
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $email = $conn->real_escape_string($_POST['email']);
        $company = $conn->real_escape_string($_POST['company']);
        // Codificar la contraseña antes de guardarla en la base de datos
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $sql = "INSERT INTO `usuarios` 
            (`nombre_us`, 
            `apellido_us`,
            `correo_us`, 
            `pass`, 
            `id_empresa`) 
            VALUES 
            ('$nombre', 
            '$apellido', 
            '$email', 
            '$password',
            '$company')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Usuario registrado exitosamente";
        } else {
            echo "Error al registrar el usuario: " . $conn->error;
        }
    }
}

if ($_POST["type"] == "Consulta_empresa") {
    // Consulta SQL para obtener las empresas
    $sql = "SELECT
        `id_empresa`,
        `nom_empresa`
    FROM `empresas`;";
    $result = $conn->query($sql);

    $empresas = array();
    // Recorre los resultados y agrega cada empresa al array
    while ($row = $result->fetch_assoc()) {
        $empresas[] = $row;
    }

    // Devuelve las empresas en formato JSON
    echo json_encode($empresas);
    // Cerrar conexión
}
$conn->close();
?>
