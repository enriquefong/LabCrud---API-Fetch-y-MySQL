<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Productos - API Fetch</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .card {
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: none;
            border-radius: 15px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        
        .btn-custom {
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="text-center mb-4">
            <h1 class="text-white fw-bold">
                <i class="bi bi-cart-check"></i> Sistema de Gestión de Productos
            </h1>
            <p class="text-white">CRUD con Fetch API + MySQL</p>
        </div>
        
        <!-- Formulario de Productos -->
        <div class="row mb-4">
            <div class="col-lg-6 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle"></i> Formulario de Productos
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="formProducto">
                            <!-- Campo oculto para el ID (usado en edición) -->
                            <input type="hidden" id="id" name="id">
                            
                            <!-- Código del Producto -->
                            <div class="mb-3">
                                <label for="codigo" class="form-label">
                                    <i class="bi bi-upc-scan"></i> Código del Producto
                                </label>
                                <input type="text" class="form-control" id="codigo" name="codigo" 
                                       placeholder="Ej: PROD001" required>
                            </div>
                            
                            <!-- Nombre del Producto -->
                            <div class="mb-3">
                                <label for="producto" class="form-label">
                                    <i class="bi bi-box-seam"></i> Nombre del Producto
                                </label>
                                <input type="text" class="form-control" id="producto" name="producto" 
                                       placeholder="Ej: Laptop Dell" required>
                            </div>
                            
                            <!-- Precio -->
                            <div class="mb-3">
                                <label for="precio" class="form-label">
                                    <i class="bi bi-currency-dollar"></i> Precio
                                </label>
                                <input type="number" class="form-control" id="precio" name="precio" 
                                       step="0.01" min="0" placeholder="0.00" required>
                            </div>
                            
                            <!-- Cantidad -->
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">
                                    <i class="bi bi-hash"></i> Cantidad
                                </label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" 
                                       min="0" placeholder="0" required>
                            </div>
                            
                            <!-- Botones -->
                            <div class="d-grid gap-2">
                                <button type="button" id="btnGuardar" class="btn btn-primary btn-custom">
                                    <i class="bi bi-save"></i> Registrar Producto
                                </button>
                                <button type="button" id="btnActualizar" class="btn btn-warning btn-custom" style="display: none;">
                                    <i class="bi bi-arrow-repeat"></i> Actualizar Producto
                                </button>
                                <button type="button" id="btnBuscar" class="btn btn-info btn-custom">
                                    <i class="bi bi-search"></i> Buscar por Código
                                </button>
                                <button type="button" id="btnCancelar" class="btn btn-secondary btn-custom" style="display: none;">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla de Productos -->
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">
                            <i class="bi bi-table"></i> Lista de Productos
                        </h4>
                        <button type="button" id="btnRefrescar" class="btn btn-success btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> Refrescar
                        </button>
                    </div>
                    
                    <!-- Alert de Bootstrap -->
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle"></i> 
                        Aquí se mostrarán todos los productos registrados en el sistema.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaProductos">
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script personalizado -->
    <script src="script.js"></script>
</body>
</html>