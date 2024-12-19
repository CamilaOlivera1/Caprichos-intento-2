<?php
session_start();
//var_dump($_SESSION);  // Esto te mostrará qué datos están almacenados en la sesión.

require_once('../php/database.php');  // Conexión a la base de datos

// Verificar si el usuario está logueado (comprobamos si existe el 'user' en la sesión)
if (!isset($_SESSION['user'])) {
    header("Location: inicioSesion.php");  // Redirigir al login si no está logueado
    exit;
}

// Usar el ID del usuario directamente desde la sesión
$usuario_id = $_SESSION['user'];  // Usamos el ID directamente de la sesión

// Verificar si el usuario existe en la base de datos
$queryUsuario = "SELECT id FROM registro WHERE id = ?";

$stmtUsuario = $pdo->prepare($queryUsuario);
$stmtUsuario->execute([$usuario_id]);

if ($stmtUsuario->rowCount() === 0) {
    die("Error: El usuario no está registrado en el sistema.");
}

// Obtener el ID del usuario desde la base de datos
$usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
$usuario_id = $usuario['id'];  // El id del usuario en la base de datos

// Verificar si hay productos en el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$totalCarrito = 0;

// Calcular el total de los productos en el carrito
foreach ($carrito as $producto) {
    $totalCarrito += $producto['precio'] * $producto['cantidad'];
}

// Definir el costo fijo de envío
$costoEnvio = 3000;

// Calcular el total de la compra
$totalCompra = $totalCarrito + $costoEnvio;

// Variables para el formulario
$queryEnvios = "SELECT * FROM envios";
$stmtEnvios = $pdo->query($queryEnvios);

// Obtener los métodos de pago
$queryMediosPago = "SELECT * FROM medioPago";
$stmtMediosPago = $pdo->query($queryMediosPago);

// Si se recibe el formulario con POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar envío
    $envio_id = $_POST['envio_id'];
    $queryEnvio = "SELECT id FROM envios WHERE id = ?";
    $stmtEnvio = $pdo->prepare($queryEnvio);
    $stmtEnvio->execute([$envio_id]);

    if ($stmtEnvio->rowCount() === 0) {
        die("Error: El tipo de envío seleccionado no es válido.");
    }

    // Validar medio de pago
    $medioPago_id = $_POST['medioPago_id'];
    $queryMedioPago = "SELECT id FROM medioPago WHERE id = ?";
    $stmtMedioPago = $pdo->prepare($queryMedioPago);
    $stmtMedioPago->execute([$medioPago_id]);

    if ($stmtMedioPago->rowCount() === 0) {
        die("Error: El medio de pago seleccionado no es válido.");
    }

    // Registrar la compra en la base de datos
    $queryCompra = "INSERT INTO compras (usuario_id, envio_id, total, medioPago_id) VALUES (?, ?, ?, ?)";
    $stmtCompra = $pdo->prepare($queryCompra);
    $stmtCompra->execute([$usuario_id, $envio_id, $totalCompra, $medioPago_id]);
    $compra_id = $pdo->lastInsertId();  // Obtener el ID de la compra recién creada

    // Verificar que los productos en el carrito tengan un ID válido
    foreach ($carrito as $id => $producto) {
        if (empty($producto['id'])) {
            die("Error: El producto no tiene un ID válido.");
        }
        $subtotalProducto = $producto['precio'] * $producto['cantidad'];

        // Insertar los productos comprados
        $queryProductoComprado = "INSERT INTO productos_comprados (compra_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)";
        $stmtProductoComprado = $pdo->prepare($queryProductoComprado);
        $stmtProductoComprado->execute([$compra_id, $producto['id'], $producto['cantidad'], $producto['precio'], $subtotalProducto]);

        // Actualizar el stock de los productos
        $queryActualizarStock = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmtActualizarStock = $pdo->prepare($queryActualizarStock);
        $stmtActualizarStock->execute([$producto['cantidad'], $producto['id']]);
    }

    // Limpiar el carrito
    unset($_SESSION['carrito']);

    // Redirigir a una página de confirmación o mostrar un mensaje
    header("Location: confirmacionCompra.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
        // Función para mostrar el formulario de tarjeta de crédito/débito
        function mostrarFormularioPago() {
            const metodoPago = document.getElementById("medioPago_id").value;
            const tarjetaForm = document.getElementById("form-tarjeta");
            if (metodoPago === "1" || metodoPago === "2") { // Asumiendo que 1 y 2 son tarjeta de crédito y débito
                tarjetaForm.style.display = "block";
            } else {
                tarjetaForm.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <div class="finalizar-compra-container">
        <header>
            <h1>Finalizar Compra</h1>
        </header>
        <section>
            <h2>Total de la Compra</h2>
            <p>Subtotal de los productos: $<?php echo number_format($totalCarrito, 0, ',', '.'); ?></p>

            <form action="finalizarCompra.php" method="post">
                <h3>Elige el tipo de envío</h3>
                <select name="envio_id" required>
                    <?php while ($envio = $stmtEnvios->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $envio['id']; ?>"><?php echo htmlspecialchars($envio['destino']) . " - $" . number_format($envio['costo'], 0, ',', '.'); ?></option>
                    <?php endwhile; ?>
                </select>

                <h3>Elige el medio de pago</h3>
                <select name="medioPago_id" id="medioPago_id" onchange="mostrarFormularioPago()" required>
                    <?php while ($medioPago = $stmtMediosPago->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $medioPago['id']; ?>"><?php echo htmlspecialchars($medioPago['nombre']); ?></option>
                    <?php endwhile; ?>
                </select>

                <h3>Costo de envío</h3>
                <p>$<?php echo number_format($costoEnvio, 0, ',', '.'); ?></p>

                <h3>Total a Pagar</h3>
                <p>$<?php echo number_format($totalCompra, 0, ',', '.'); ?></p>

                <!-- Formulario de tarjeta de crédito/débito -->
                <div id="form-tarjeta" style="display:none;">
                    <h3>Datos de la tarjeta</h3>
                    <label for="numero_tarjeta">Número de tarjeta:</label>
                    <input type="text" id="numero_tarjeta" name="numero_tarjeta" placeholder="1234 5678 9012 3456" required>
                    <label for="fecha_expiracion">Fecha de expiración:</label>
                    <input type="month" id="fecha_expiracion" name="fecha_expiracion" required>
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" placeholder="123" required>
                </div>

                <button type="submit">Finalizar Compra</button>
            </form>
        </section>
    </div>
</body>
</html>
