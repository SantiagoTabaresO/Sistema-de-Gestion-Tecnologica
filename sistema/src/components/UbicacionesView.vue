<template>
    <div class="dashboard-container">
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <h1>
                    <span><i class="fas fa-map-marker-alt"></i></span> Ubicaciones
                </h1>
            </div>

            <!-- Search Bar -->
            <div class="search-bar">
                <input 
                    type="text" 
                    placeholder="Buscar por nombre o código asignado"
                    v-model="busqueda"
                />
            </div>

            <!-- Tabla -->
            <div class="table-container">
                <h2>Listado de Ubicaciones ({{ ubicaciones.length }} registros)</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="ubicacion in ubicacionesFiltradas" 
                            :key="ubicacion.id">
                            <td>{{ ubicacion.codigo_asignado }}</td>
                            <td>{{ ubicacion.nombre_ubicacion }}</td>
                            <td>{{ ubicacion.ubicacion }}</td>
                            <td>{{ ubicacion.telefono }}</td>
                            <td>
                                <router-link 
                                    v-if="ubicacion.id"
                                    :to="{name:'EditarUbicacionView', params:{id:ubicacion.id}}" 
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i> Editar
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="ubicacionesFiltradas.length === 0" class="text-center p-4 text-muted">
                    No se encontraron ubicaciones.
                </div>
            </div>

            <!-- Acciones -->
            <div class="action-section">
                <router-link 
                :to="{ name: 'CrearUbicacionView' }" 
                class="btn btn-purple">
                <i class="fas fa-plus"></i> CREAR REGISTRO
                </router-link>


                <div class="delete-area">
                    <label for="codigo-eliminar">
                        Escriba el <b>código</b> asignado de la ubicación a 
                        <span class="text-danger">ELIMINAR</span>:
                    </label>
                    <input 
                        type="text" 
                        id="codigo-eliminar" 
                        placeholder="Ej: UB-001"
                        v-model="codigoAEliminar"
                    />
                    <button 
                        class="btn btn-red"
                        @click="borrarUbicacionPorCodigo"
                        :disabled="!codigoAEliminar">
                        <i class="fas fa-trash-alt"></i> ELIMINAR
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            ubicaciones: [],
            busqueda: '',
            codigoAEliminar: ''
        }
    },
    computed: {
        ubicacionesFiltradas() {
            if (!this.busqueda) return this.ubicaciones;
            return this.ubicaciones.filter(u =>
                u.codigo_asignado.toLowerCase().includes(this.busqueda.toLowerCase()) ||
                u.nombre_ubicacion.toLowerCase().includes(this.busqueda.toLowerCase())
            );
        }
    },
    created() {
        this.consultarUbicaciones();
    },
    methods: {
        consultarUbicaciones() {
            fetch('http://localhost/sist_gestion/index.php?resource=ubicaciones')
                .then(res => res.json())
                .then((data) => {
                    if (Array.isArray(data)) {
                        this.ubicaciones = data;
                    } else {
                        this.ubicaciones = [];
                    }
                })
                .catch(err => console.error('Error al consultar ubicaciones:', err));
        },
        borrarUbicacionPorCodigo() {
            const codigo = this.codigoAEliminar;
            const ubicacion = this.ubicaciones.find(u => u.codigo_asignado === codigo);

            if (ubicacion && ubicacion.id) {
                if (confirm(`¿Está seguro de eliminar la ubicación con código ${codigo}?`)) {
                    fetch(`http://localhost/sist_gestion/index.php?resource=ubicaciones&borrar=${ubicacion.id}`)
                        .then(res => res.json())
                        .then(() => {
                            this.consultarUbicaciones();
                            this.codigoAEliminar = '';
                        })
                        .catch(err => console.error('Error al borrar ubicación:', err));
                }
            } else {
                alert(`No se encontró una ubicación con el código: ${codigo}.`);
            }
        }
    }
}
</script>

<style scoped>
/* Estilos iguales al HTML base */
.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar */
.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: white;
    padding: 20px 0;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}
.sidebar h3 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 1.5em;
    color: #ecf0f1;
}
.menu-item {
    padding: 15px 20px;
    cursor: pointer;
    border-left: 5px solid transparent;
    display: flex;
    align-items: center;
    gap: 10px;
}
.menu-item:hover {
    background-color: #34495e;
}
.menu-item.active {
    background-color: #1abc9c;
    border-left: 5px solid #2ecc71;
    font-weight: bold;
}

/* Main content */
.main-content {
    flex-grow: 1;
    padding: 30px;
    background-color: #f4f7f6;
}
.header {
    margin-bottom: 30px;
}
.header h1 {
    font-size: 2.5em;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
}
.header h1 span {
    font-weight: normal;
    font-size: 0.8em;
    margin-right: 15px;
    color: #1abc9c;
}

/* Search bar */
.search-bar {
    margin-bottom: 20px;
    display: flex;
}
.search-bar input {
    padding: 10px 15px 10px 40px;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 1em;
    outline: none;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="%23999" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>');
    background-repeat: no-repeat;
    background-position: 10px center;
}

/* Tabla */
.table-container {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow-x: auto;
}
.data-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}
.data-table th, .data-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #eee;
}
.data-table th {
    background-color: #ecf0f1;
    color: #333;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9em;
}
.data-table tr:hover {
    background-color: #f9f9f9;
}

/* Acciones */
.action-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #ddd;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.btn {
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s;
}
.btn-purple {
    background-color: #8e44ad;
    color: white;
}
.btn-purple:hover {
    background-color: #9b59b6;
}
.delete-area {
    background-color: #ffebee;
    padding: 15px;
    border-radius: 5px;
    border: 1px solid #e74c3c;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.delete-area label {
    font-weight: 600;
    color: #c0392b;
}
.delete-area input {
    padding: 8px;
    border: 1px solid #e74c3c;
    border-radius: 3px;
    font-size: 1em;
}
.btn-red {
    background-color: #e74c3c;
    color: white;
    align-self: flex-start;
}
.btn-red:hover {
    background-color: #c0392b;
}
</style>
