<?php
// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

// Incluir el modelo de productos
require_once 'Modelo/Productos.php';

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido',
        'errors' => ['Solo se permiten peticiones POST']
    ]);
    exit;
}

// Obtener la acción del formulario
$accion = isset($_POST['Accion']) ? $_POST['Accion'] : '';

// Crear instancia de Producto
$producto = new Producto();

// Switch para manejar las diferentes acciones
switch ($accion) {
    case 'Guardar':
        // Establecer los datos del producto
        $producto->setCodigo($_POST['codigo'] ?? '');
        $producto->setProducto($_POST['producto'] ?? '');
        $producto->setPrecio($_POST['precio'] ?? '');
        $producto->setCantidad($_POST['cantidad'] ?? '');
        
        // Guardar el producto
        $respuesta = $producto->guardar();
        echo json_encode($respuesta);
        break;
        
    case 'Modificar':
        // Establecer los datos del producto incluyendo el ID
        $producto->setId($_POST['id'] ?? '');
        $producto->setCodigo($_POST['codigo'] ?? '');
        $producto->setProducto($_POST['producto'] ?? '');
        $producto->setPrecio($_POST['precio'] ?? '');
        $producto->setCantidad($_POST['cantidad'] ?? '');
        
        // Editar el producto
        $respuesta = $producto->editar();
        echo json_encode($respuesta);
        break;
        
    case 'Buscar':
        // Buscar producto por código
        $codigo = $_POST['codigo'] ?? '';
        
        if (empty($codigo)) {
            echo json_encode([
                'success' => false,
                'message' => 'Código no proporcionado',
                'errors' => ['Debe ingresar un código para buscar']
            ]);
        } else {
            $resultado = $producto->buscar($codigo);
            
            if ($resultado) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto encontrado',
                    'data' => $resultado,
                    'errors' => []
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Producto no encontrado',
                    'errors' => ['No existe un producto con ese código']
                ]);
            }
        }
        break;
        
    default:
        // Acción no válida
        echo json_encode([
            'success' => false,
            'message' => 'Acción no válida',
            'errors' => ['La acción especificada no es válida']
        ]);
        break;
}
?>