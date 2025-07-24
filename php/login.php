<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            header("Location: ../inicio.html");
            exit();
        } else {
            mostrarMensajeError("Contraseña incorrecta");
        }
    } else {
        mostrarMensajeError("Usuario no encontrado");
    }

    $stmt->close();
    $conn->close();
}

function mostrarMensajeError($mensaje) {
    echo "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Error de inicio de sesión</title>
        <style>
            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: #f5f5f5;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .card {
                background: #ffffff;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                padding: 30px;
                max-width: 400px;
                text-align: center;
            }
            .card h2 {
                color: #e53935;
                margin-bottom: 15px;
            }
            .card p {
                margin-bottom: 20px;
                color: #333333;
            }
            .btn {
                background-color: #2e7d32;
                color: white;
                border: none;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 6px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            .btn:hover {
                background-color: #1b5e20;
            }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2>❌ $mensaje</h2>
            <p>Por favor, verifica tus datos e intenta nuevamente.</p>
            <a class='btn' href='../index.html'>Volver al inicio</a>
        </div>
    </body>
    </html>
    ";
    exit();
}
?>
