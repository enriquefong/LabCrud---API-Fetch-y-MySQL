<?php
/**
 * Clase DB - Conexión a la base de datos usando PDO
 * Patrón Singleton para una única instancia de conexión
 */
class DB {
    private static $instance = null;
    private $conexion;
    
    // Configuración de la base de datos
    private $host = "localhost";
    private $dbname = "productosdb";
    private $usuario = "root";
    private $password = "";
    
    /**
     * Constructor privado para implementar Singleton
     */
    private function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->usuario,
                $this->password
            );
            // Configurar PDO para lanzar excepciones en caso de error
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    /**
     * Obtener la instancia única de la clase
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
    
    /**
     * Obtener la conexión PDO
     */
    public function getConexion() {
        return $this->conexion;
    }
    
    /**
     * Insertar datos de forma segura usando prepared statements
     */
    public function insertSeguro($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error en insertSeguro: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualizar datos de forma segura usando prepared statements
     */
    public function updateSeguro($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error en updateSeguro: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Ejecutar consultas SELECT de forma segura
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en query: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Obtener el último ID insertado
     */
    public function lastInsertId() {
        return $this->conexion->lastInsertId();
    }
}
?>