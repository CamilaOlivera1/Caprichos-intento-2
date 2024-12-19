<?php
session_start();

// Verificar si hay productos en el carrito
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Función para eliminar un producto del carrito
if (isset($_GET['eliminar'])) {
    $producto_id = $_GET['eliminar'];
    unset($_SESSION['carrito'][$producto_id]);
    header("Location: carrito.php");
    exit;
}

// Función para actualizar la cantidad de un producto en el carrito
if (isset($_POST['producto_id']) && isset($_POST['cantidad'])) {
    $producto_id = $_POST['producto_id'];
    $nueva_cantidad = $_POST['cantidad'];

    if (isset($_SESSION['carrito'][$producto_id])) {
        if ($nueva_cantidad > 0) {
            $_SESSION['carrito'][$producto_id]['cantidad'] = $nueva_cantidad;
        } else {
            unset($_SESSION['carrito'][$producto_id]); // Eliminar el producto si la cantidad es 0 o negativa
        }
        header("Location: carrito.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Contenedor con la clase personalizada -->
    <div class="carrito-container">
        <header>
            <h1>Carrito de Compras</h1>
        </header>

        <section class="carrito">
            <?php if (empty($carrito)): ?>
                <p>Tu carrito está vacío. <a href="../index.php">Volver a la tienda</a></p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalCarrito = 0;
                        foreach ($carrito as $id => $producto): 
                            $subtotal = $producto['precio'] * $producto['cantidad'];
                            $totalCarrito += $subtotal;
                        ?>
                            <tr>
                                <td><img src="../imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>"></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Formulario para actualizar la cantidad -->
                                    <form action="carrito.php" method="post" style="display: inline-block;">
                                        <input type="hidden" name="producto_id" value="<?php echo $id; ?>">
                                        <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" min="1" required>
                                        <button type="submit">Actualizar</button>
                                    </form>
                                </td>
                                <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                                <td>
                                    <!-- Enlace para eliminar el producto -->
                                    <a href="carrito.php?eliminar=<?php echo $id; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Total</td>
                            <td>$<?php echo number_format($totalCarrito, 0, ',', '.'); ?></td>
                        </tr>
                    </tfoot>
                </table>
                <a href="finalizarCompra.php" class="btn-finalizar">Finalizar Compra</a>
                <a href="../index.php" class="btn-volver">Seguir Comprando</a>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
