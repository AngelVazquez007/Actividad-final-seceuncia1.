<?php
// Verificar si se recibió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se recibió la acción y procesar según corresponda
    if (isset($_SERVER['HTTP_ACCION'])) {
        $accion = $_SERVER['HTTP_ACCION'];

        switch ($accion) {
            case 'registrarProducto':
                registrarProducto();
                break;
            case 'registrarProveedor':
                registrarProveedor();
                break;
            case 'registrarCompra':
                registrarCompra();
                break;
            case 'registrarVenta':
                registrarVenta();
                break;
            default:
                http_response_code(400);
                echo "Acción no válida.";
                break;
        }
    } else {
        http_response_code(400);
        echo "No se especificó ninguna acción.";
    }
} else {
    http_response_code(405);
    echo "Método no permitido.";
}

function conectarBaseDeDatos() {
    // Cambiar estas configuraciones según tu base de datos
    $servidor = "localhost";
    $usuario = "root";
    $contrasena = "";
    $basededatos = "tu_basededatos";

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $contrasena);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

function registrarProducto() {
    // Aquí deberías obtener los datos del formulario
    $nombre = $_POST['nombre_producto'];
    $precio = $_POST['precio_producto'];
    $cantidad = $_POST['cantidad_stock'];
    $categoria = $_POST['categoria_producto'];

    // Ejemplo de inserción en la base de datos
    $conexion = conectarBaseDeDatos();
    $consulta = $conexion->prepare("INSERT INTO productos (nombre, precio, cantidad, categoria) VALUES (?, ?, ?, ?)");
    $resultado = $consulta->execute([$nombre, $precio, $cantidad, $categoria]);

    // Ejemplo de respuesta al frontend
    if ($resultado) {
        http_response_code(200);
        echo "Producto registrado correctamente.";
    } else {
        http_response_code(500);
        echo "Error al registrar el producto.";
    }
}

function registrarProveedor() {
    // Aquí deberías obtener los datos del formulario
    $nombre = $_POST['nombre_proveedor'];
    $direccion = $_POST['direccion_proveedor'];
    $telefono = $_POST['telefono_proveedor'];
    $email = $_POST['email_proveedor'];

    // Ejemplo de inserción en la base de datos
    $conexion = conectarBaseDeDatos();
    $consulta = $conexion->prepare("INSERT INTO proveedores (nombre, direccion, telefono, email) VALUES (?, ?, ?, ?)");
    $consulta->execute([$nombre, $direccion, $telefono, $email]);

    // Ejemplo de respuesta al frontend
    http_response_code(200);
    echo "Proveedor registrado correctamente.";
}

function registrarCompra() {
    // Implementa la lógica para registrar una compra en la base de datos
    // Similar a las funciones anteriores
}

function registrarVenta() {
    // Implementa la lógica para registrar una venta en la base de datos
    // Similar a las funciones anteriores
}
?>
