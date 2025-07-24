<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Validar si ya existe el correo
    $sql_check = "SELECT * FROM usuario WHERE correo = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows > 0) {
        echo "El correo ya está registrado. <a href='../registro.html'>Volver</a>";
    } else {
        $sql = "INSERT INTO usuario (nombre, apellido, correo, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $apellido, $correo, $password);

        if ($stmt->execute()) {
            header("Location: ../index.html"); // Redirige al login
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
    }

    $stmt_check->close();
    $conn->close();
}
?>