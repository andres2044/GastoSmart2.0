<?php
require 'conexion.php';
$usuario_id = 1; // por ahora es fijo, luego puedes usar $_SESSION['usuario_id']

// Obtener todos los gastos
$sql_gastos = "SELECT categoria, descripcion, monto, fecha FROM gasto WHERE usuario_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql_gastos);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$total_gastos = 0;
echo "<h2>🧾 Gastos Realizados</h2>";

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Categoría</th><th>Descripción</th><th>Monto</th><th>Fecha</th></tr>";
    while ($row = $result->fetch_assoc()) {
        $total_gastos += $row['monto'];
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['descripcion']}</td>";
        echo "<td>$" . number_format($row['monto'], 2) . "</td>";
        echo "<td>{$row['fecha']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay gastos registrados.</p>";
}
$stmt->close();

// Obtener presupuesto total
$sql_presupuesto = "SELECT SUM(monto) AS total_presupuesto FROM presupuesto WHERE usuario_id = ?";
$stmt = $conn->prepare($sql_presupuesto);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_presupuesto = $row['total_presupuesto'] ?? 0;

$restante = $total_presupuesto - $total_gastos;

echo "<div class='totales'>";
echo "<p>💰 Presupuesto total: $" . number_format($total_presupuesto, 2) . "</p>";
echo "<p>💸 Total gastado: $" . number_format($total_gastos, 2) . "</p>";
echo "<p>🟢 Dinero restante: $" . number_format($restante, 2) . "</p>";
echo "</div>";

$stmt->close();
$conn->close();
?>