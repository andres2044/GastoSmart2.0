<?php
require 'conexion.php'; // conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoria = $_POST['categoria'] ?? '';
    $monto = $_POST['monto'] ?? '';
    $fecha_inicio = $_POST['fecha_inicio'] ?? '';
    $fecha_fin = $_POST['fecha_fin'] ?? '';
    $usuario_id = 1; // valor fijo por ahora, cambiar por $_SESSION['usuario_id'] si usas login

    // Validación
    if (empty($categoria) || empty($monto) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo "<script>alert('❌ Todos los campos son obligatorios'); window.location.href = '../presupuesto.html';</script>";
        exit;
    }

    // Insertar presupuesto
    $sql = "INSERT INTO presupuesto (categoria, monto, fecha_inicio, fecha_fin, usuario_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en prepare: " . $conn->error);
    }

    $stmt->bind_param("dsssi", $monto, $fecha_inicio, $fecha_fin, $categoria, $usuario_id);  // esta línea está mal

    // CORRECTO:
    $stmt->bind_param("dsssi", $monto, $fecha_inicio, $fecha_fin, $categoria, $usuario_id);  // tampoco, está mal el orden

    // CORRECTO (ORDEN VERDADERO):
    $stmt->bind_param("sdssi", $categoria, $monto, $fecha_inicio, $fecha_fin, $usuario_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Presupuesto registrado correctamente'); window.location.href = '../presupuesto.html';</script>";
    } else {
        echo "<script>alert('❌ Error al registrar presupuesto: " . $stmt->error . "'); window.location.href = '../presupuesto.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../presupuesto.html");
    exit;
}
?>
