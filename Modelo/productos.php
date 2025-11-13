<?php
require_once 'conexion.php';

/**
 * Clase Producto - Maneja las operaciones CRUD de productos
 */
class Producto {
    private $db;
    private $id;
    private $codigo;
    private $producto;
    private $precio;
    private $cantidad;
    private $errors = [];
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->db = DB::getInstance();
    }
    
    /**
     * Setters
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setCodigo($codigo) {
        $this->codigo = trim($codigo);
    }
    
    public function setProducto($producto) {
        $this->producto = trim($producto);
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    
    /**
     * Getters
     */
    public function getId() {
        return $this->id;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }
    
    public function getProducto() {
        return $this->producto;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Validar datos del producto
     */
    private function validar() {
        $this->errors = [];
        
        // Validar código
        if (empty($this->codigo)) {
            $this->errors[] = "El código es obligatorio";
        } elseif (strlen($this->codigo) > 20) {
            $this->errors[] = "El código no puede tener más de 20 caracteres";
        }
        
        // Validar producto
        if (empty($this->producto)) {
            $this->errors[] = "El nombre del producto es obligatorio";
        } elseif (strlen($this->producto) > 100) {
            $this->errors[] = "El nombre del producto no puede tener más de 100 caracteres";
        }
        
        // Validar precio
        if (empty($this->precio) && $this->precio !== '0') {
            $this->errors[] = "El precio es obligatorio";
        } elseif (!is_numeric($this->precio) || $this->precio < 0) {
            $this->errors[] = "El precio debe ser un número positivo";
        }
        
        // Validar cantidad
        if (empty($this->cantidad) && $this->cantidad !== '0') {
            $this->errors[] = "La cantidad es obligatoria";
        } elseif (!is_numeric($this->cantidad) || $this->cantidad < 0 || floor($this->cantidad) != $this->cantidad) {
            $this->errors[] = "La cantidad debe ser un número entero positivo";
        }
        
        return empty($this->errors);
    }
    
    /**
     * Guardar un nuevo producto en la base de datos
     */
    public function guardar() {
        // Validar datos
        if (!$this->validar()) {
            return [
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $this->errors
            ];
        }
        
        // Verificar si el código ya existe
        $sql = "SELECT id FROM productos WHERE codigo = ?";
        $resultado = $this->db->query($sql, [$this->codigo]);
        
        if (!empty($resultado)) {
            return [
                'success' => false,
                'message' => 'El código de producto ya existe',
                'errors' => ['El código de producto ya está registrado']
            ];
        }
        
        // Insertar el producto
        $sql = "INSERT INTO productos (codigo, producto, precio, cantidad) VALUES (?, ?, ?, ?)";
        $params = [$this->codigo, $this->producto, $this->precio, $this->cantidad];
        
        if ($this->db->insertSeguro($sql, $params)) {
            return [
                'success' => true,
                'message' => 'Producto guardado exitosamente',
                'accion' => 'Guardar',
                'errors' => []
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al guardar el producto',
                'errors' => ['No se pudo guardar el producto en la base de datos']
            ];
        }
    }
    
    /**
     * Editar un producto existente
     */
    public function editar() {
        // Validar datos
        if (!$this->validar()) {
            return [
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $this->errors
            ];
        }
        
        // Validar que el ID esté presente
        if (empty($this->id)) {
            return [
                'success' => false,
                'message' => 'ID de producto no proporcionado',
                'errors' => ['Se requiere el ID del producto para modificarlo']
            ];
        }
        
        // Verificar si el código ya existe en otro producto
        $sql = "SELECT id FROM productos WHERE codigo = ? AND id != ?";
        $resultado = $this->db->query($sql, [$this->codigo, $this->id]);
        
        if (!empty($resultado)) {
            return [
                'success' => false,
                'message' => 'El código de producto ya existe',
                'errors' => ['El código ya está asignado a otro producto']
            ];
        }
        
        // Actualizar el producto
        $sql = "UPDATE productos SET codigo = ?, producto = ?, precio = ?, cantidad = ? WHERE id = ?";
        $params = [$this->codigo, $this->producto, $this->precio, $this->cantidad, $this->id];
        
        if ($this->db->updateSeguro($sql, $params)) {
            return [
                'success' => true,
                'message' => 'Producto actualizado exitosamente',
                'accion' => 'Modificar',
                'errors' => []
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al actualizar el producto',
                'errors' => ['No se pudo actualizar el producto en la base de datos']
            ];
        }
    }
    
    /**
     * Buscar un producto por código
     */
    public function buscar($codigo) {
        $sql = "SELECT * FROM productos WHERE codigo = ?";
        $resultado = $this->db->query($sql, [$codigo]);
        
        if (!empty($resultado)) {
            return $resultado[0];
        }
        
        return null;
    }
    
    /**
     * Listar todos los productos
     * @return array - Lista de productos
     */
    public function listar() {
        $sql = "SELECT * FROM productos ORDER BY id DESC";
        return $this->db->query($sql);
    }
}
?>