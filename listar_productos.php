<?php
// Establecer el tipo de contenido como JSON
header("Content-Type: application/json");

// Incluir el modelo de productos
require_once 'Modelo/Productos.php';

// Crear instancia de Producto
$producto = new Producto();

// Listar todos los productos
$productos = $producto->listar();

// Retornar la respuesta en formato JSON
echo json_encode([
    'success' => true,
    'data' => $productos
]);
?>