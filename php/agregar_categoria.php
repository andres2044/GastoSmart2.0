<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $presupuesto = $_POST['presupuesto'];

    $sql = "INSERT INTO categoria (nombre, descripcion, presupuesto_mensual) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $nombre, $descripcion, $presupuesto);

    if ($stmt->execute()) {
        echo "
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Categoría agregada</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f5f5f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
                .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; }
                .card h2 { color: #2e7d32; }
                .btn { background-color: #2e7d32; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; display: inline-block; margin-top: 15px; }
                .btn:hover { background-color: #1b5e20; }
            </style>
        </head>
        <body>
            <div class='card'>
                <h2>✅ Categoría agregada correctamente</h2>
                <a href='../categoria.html' class='btn'>Agregar otra</a>
                <a href='../inicio.html' class='btn' style='background-color:#424242;'>Volver al inicio</a>
            </div>
        </body>
        </html>
        ";
    } else {
        echo "Error al agregar la categoría: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
