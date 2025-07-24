<?php
require 'conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $monto = $_POST['monto'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $usuario_id = 1; // Usuario por defecto. Cambiar por $_SESSION['id_usuario'] si usas login.

    // Validación
    if (empty($categoria) || empty($descripcion) || empty($monto) || empty($fecha)) {
        echo "<script>alert('❌ Todos los campos son obligatorios'); window.location.href = '../gasto.html';</script>";
        exit;
    }

    // Insertar gasto
    $sql = "INSERT INTO gasto (categoria, descripcion, monto, fecha, usuario_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en prepare: " . $conn->error);
    }

    $stmt->bind_param("ssdsi", $categoria, $descripcion, $monto, $fecha, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Gasto registrado correctamente'); window.location.href = '../gasto.html';</script>";
    } else {
        echo "<script>alert('❌ Error al registrar el gasto: " . $stmt->error . "'); window.location.href = '../gasto.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../gasto.html");
    exit;
}
?>
