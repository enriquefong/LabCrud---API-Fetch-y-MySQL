/**
 * Script.js - Manejo de eventos y peticiones con Fetch API
 * Implementa switch para las diferentes acciones del CRUD
 */

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos del DOM
    const formProducto = document.getElementById('formProducto');
    const btnGuardar = document.getElementById('btnGuardar');
    const btnActualizar = document.getElementById('btnActualizar');
    const btnBuscar = document.getElementById('btnBuscar');
    const btnCancelar = document.getElementById('btnCancelar');
    const btnRefrescar = document.getElementById('btnRefrescar');
    
    // Cargar productos al inicio
    listarProductos();
    
    /**
     * Event Listener para el botón Guardar
     */
    btnGuardar.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validar formulario
        if (!validarFormulario()) {
            return;
        }
        
        // Crear FormData con los datos del formulario
        const formData = new FormData(formProducto);
        formData.append('Accion', 'Guardar');
        
        // Realizar petición con Fetch
        realizarPeticion(formData);
    });
    
    /**
     * Event Listener para el botón Actualizar
     */
    btnActualizar.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validar formulario
        if (!validarFormulario()) {
            return;
        }
        
        // Crear FormData con los datos del formulario
        const formData = new FormData(formProducto);
        formData.append('Accion', 'Modificar');
        
        // Realizar petición con Fetch
        realizarPeticion(formData);
    });
    
    /**
     * Event Listener para el botón Buscar
     */
    btnBuscar.addEventListener('click', function(e) {
        e.preventDefault();
        
        const codigo = document.getElementById('codigo').value.trim();
        
        if (codigo === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo Requerido',
                text: 'Por favor ingrese un código para buscar',
                confirmButtonColor: '#667eea'
            });
            return;
        }
        
        // Crear FormData para buscar
        const formData = new FormData();
        formData.append('codigo', codigo);
        formData.append('Accion', 'Buscar');
        
        // Realizar petición de búsqueda
        buscarProducto(formData);
    });
    
    /**
     * Event Listener para el botón Cancelar
     */
    btnCancelar.addEventListener('click', function() {
        limpiarFormulario();
        modoRegistro();
    });
    
    /**
     * Event Listener para el botón Refrescar
     */
    btnRefrescar.addEventListener('click', function() {
        listarProductos();
    });
    
    /**
     * Función para realizar peticiones con Fetch API
     */
    function realizarPeticion(formData) {
        // Obtener la acción
        const accion = formData.get('Accion');
        
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Procesando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Realizar petición con Fetch
        fetch('registrar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            // Verificar si la respuesta es correcta
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            // Switch para manejar la respuesta según la acción
            switch(accion) {
                case 'Guardar':
                    manejarRespuestaGuardar(data);
                    break;
                case 'Modificar':
                    manejarRespuestaModificar(data);
                    break;
                default:
                    console.error('Acción desconocida:', accion);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: 'No se pudo conectar con el servidor',
                confirmButtonColor: '#667eea'
            });
        });
    }
    
    /**
     * Función para buscar producto
     */
    function buscarProducto(formData) {
        // Mostrar indicador de carga
        Swal.fire({
            title: 'Buscando...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        fetch('registrar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Producto encontrado - llenar el formulario
                document.getElementById('id').value = data.data.id;
                document.getElementById('codigo').value = data.data.codigo;
                document.getElementById('producto').value = data.data.producto;
                document.getElementById('precio').value = data.data.precio;
                document.getElementById('cantidad').value = data.data.cantidad;
                
                // Cambiar a modo edición
                modoEdicion();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Producto Encontrado',
                    text: data.message,
                    confirmButtonColor: '#667eea'
                });
            } else {
                // Producto no encontrado
                Swal.fire({
                    icon: 'error',
                    title: 'No Encontrado',
                    text: data.message,
                    confirmButtonColor: '#667eea'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al buscar el producto',
                confirmButtonColor: '#667eea'
            });
        });
    }
    
    /**
     * Manejar respuesta de Guardar
     */
    function manejarRespuestaGuardar(data) {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                confirmButtonColor: '#667eea'
            }).then(() => {
                limpiarFormulario();
                listarProductos();
            });
        } else {
            mostrarErrores(data);
        }
    }
    
    /**
     * Manejar respuesta de Modificar
     */
    function manejarRespuestaModificar(data) {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: data.message,
                confirmButtonColor: '#667eea'
            }).then(() => {
                limpiarFormulario();
                modoRegistro();
                listarProductos();
            });
        } else {
            mostrarErrores(data);
        }
    }
    
    /**
     * Mostrar errores de validación
     */
    function mostrarErrores(data) {
        let erroresHTML = '';
        if (data.errors && data.errors.length > 0) {
            erroresHTML = '<ul class="text-start">';
            data.errors.forEach(error => {
                erroresHTML += `<li>${error}</li>`;
            });
            erroresHTML += '</ul>';
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error de Validación',
            html: data.message + erroresHTML,
            confirmButtonColor: '#667eea'
        });
    }
    
    /**
     * Validar formulario antes de enviar
     */
    function validarFormulario() {
        const codigo = document.getElementById('codigo').value.trim();
        const producto = document.getElementById('producto').value.trim();
        const precio = document.getElementById('precio').value;
        const cantidad = document.getElementById('cantidad').value;
        
        if (codigo === '' || producto === '' || precio === '' || cantidad === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Incompletos',
                text: 'Por favor complete todos los campos',
                confirmButtonColor: '#667eea'
            });
            return false;
        }
        
        if (parseFloat(precio) < 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Precio Inválido',
                text: 'El precio no puede ser negativo',
                confirmButtonColor: '#667eea'
            });
            return false;
        }
        
        if (parseInt(cantidad) < 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Cantidad Inválida',
                text: 'La cantidad no puede ser negativa',
                confirmButtonColor: '#667eea'
            });
            return false;
        }
        
        return true;
    }
    
    /**
     * Listar todos los productos en la tabla
     */
    function listarProductos() {
        fetch('listar_productos.php')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tablaProductos');
            
            if (data.success && data.data.length > 0) {
                let html = '';
                data.data.forEach(producto => {
                    html += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.codigo}</td>
                            <td>${producto.producto}</td>
                            <td>${parseFloat(producto.precio).toFixed(2)}</td>
                            <td>${producto.cantidad}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="editarProducto(${producto.id}, '${producto.codigo}', '${producto.producto}', ${producto.precio}, ${producto.cantidad})">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                            </td>
                        </tr>
                    `;
                });
                tbody.innerHTML = html;
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">
                            <i class="bi bi-inbox"></i> No hay productos registrados
                        </td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('tablaProductos').innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Error al cargar productos
                    </td>
                </tr>
            `;
        });
    }
    
    /**
     * Cambiar a modo edición
     */
    function modoEdicion() {
        btnGuardar.style.display = 'none';
        btnActualizar.style.display = 'block';
        btnCancelar.style.display = 'block';
        document.getElementById('codigo').setAttribute('readonly', true);
    }
    
    /**
     * Cambiar a modo registro
     */
    function modoRegistro() {
        btnGuardar.style.display = 'block';
        btnActualizar.style.display = 'none';
        btnCancelar.style.display = 'none';
        document.getElementById('codigo').removeAttribute('readonly');
    }
    
    /**
     * Limpiar formulario
     */
    function limpiarFormulario() {
        formProducto.reset();
        document.getElementById('id').value = '';
    }
    
    /**
     * Hacer la función editarProducto global
     */
    window.editarProducto = function(id, codigo, producto, precio, cantidad) {
        document.getElementById('id').value = id;
        document.getElementById('codigo').value = codigo;
        document.getElementById('producto').value = producto;
        document.getElementById('precio').value = precio;
        document.getElementById('cantidad').value = cantidad;
        
        modoEdicion();
        
        // Scroll al formulario
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
});