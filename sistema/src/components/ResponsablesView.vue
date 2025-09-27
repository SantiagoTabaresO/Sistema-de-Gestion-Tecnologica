<template>
    <div id="app-layout" class="d-flex">
        
        <div class="sidebar bg-light p-3 border-end">
            <h2 class="mb-5 text-dark">SyncLab</h2>
            <ul class="list-unstyled">
                <li><a href="#" class="text-dark d-block py-2">🏠 Inicio</a></li>
                <li><a href="#" class="text-dark d-block py-2">📍 Ubicaciones</a></li>
                <li><a href="#" class="text-dark d-block py-2">🩺 Equipo médico</a></li>
                <li class="active-link"><a href="#" class="d-block py-2 text-decoration-none">👤 Responsables</a></li>
            </ul>
        </div>
        
        <div class="main-content flex-grow-1 p-4">
            
            <div class="container-fluid px-0 main-container">
                
                <div class="header d-flex justify-content-between align-items-center mb-4">
                    <h1>👥 Responsables por equipo</h1>
                </div>

                <div class="mb-4">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" placeholder="Buscar por nombre, documento de identidad o código asignado 🔍" aria-label="Búsqueda"/>
                        <button class="btn btn-primary" type="button" id="button-addon2">Buscar</button> 
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Listado de Responsables ({{ responsables.length }} registros)</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover m-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">CÓDIGO</th>
                                        <th scope="col">DOCUMENTO DE IDENTIDAD</th>
                                        <th scope="col">NOMBRE Y APELLIDOS</th>
                                        <th scope="col">CARGO</th>
                                        <th scope="col">TELÉFONO</th>
                                        <th scope="col">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="responsable in responsables" :key="responsable.id">
                                        <td>{{ responsable.id }}</td>
                                        <td>{{ responsable.codigo_asignado }}</td>
                                        <td>{{ responsable.documento_identidad }}</td>
                                        <td>{{ responsable.nombre_apellidos }}</td>
                                        <td>{{ responsable.cargo }}</td>
                                        <td>{{ responsable.telefono }}</td>
                                        <td>
                                            <router-link 
                                                v-if="responsable.id"
                                                :to="{name:'EditarRespView', params:{id:responsable.id}}" 
                                                class="btn btn-sm btn-outline-secondary">
                                                Editar
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div v-if="responsables.length === 0" class="text-center p-4 text-muted">
                                No se encontraron responsables.
                            </div>
                        </div>
                    </div>
                </div>

                <router-link 
                    :to="{name:'EditarRespView'}" 
                    class="btn btn-primary btn-lg create-update-btn mb-4">
                    + CREAR / ACTUALIZAR REGISTRO
                </router-link>


                <div class="eliminar-container p-4 border rounded shadow-sm mt-5">
                    <p>
                        <strong>Escriba el "*código*" asignado del registro a "</strong><span class="text-danger">**ELIMINAR**</span>**":**
                    </p>
                    <div class="d-flex align-items-center">
                        <input 
                            type="text" 
                            class="form-control me-2" 
                            placeholder="Ej: R-001" 
                            v-model="codigoAEliminar"
                        />
                        <button 
                            type="button" 
                            class="btn btn-danger btn-lg eliminar-btn" 
                            @click="borrarResponsablePorCodigo"
                            :disabled="!codigoAEliminar">
                            ELIMINAR ❌
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                responsables: [],
                codigoAEliminar: '' 
            }
        },
        created:function(){
            this.consultarResponsables();
        },
        methods:{
            consultarResponsables(){
                // URL corregida y funcionando
                fetch('http://localhost/sist_gestion/index.php?resource=responsables')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta)=>{
                    console.log('Datos de Responsables recibidos:', datosRespuesta)
                    
                    if(Array.isArray(datosRespuesta)){
                        this.responsables = datosRespuesta;
                    } 
                    else {
                         this.responsables = [];
                    }
                })
                .catch(error => {
                    console.error('Error al consultar responsables:', error);
                })
            },
            
            borrarResponsablePorCodigo(){
                const codigo = this.codigoAEliminar;
                if (!codigo) return;

                const responsable = this.responsables.find(r => r.codigo_asignado === codigo);
                
                if (responsable && responsable.id) {
                    if (confirm(`¿Está seguro de eliminar al responsable con código ${codigo}?`)) {
                        fetch(`http://localhost/sist_gestion/index.php?resource=responsables&borrar=${responsable.id}`)
                        .then(respuesta => respuesta.json())
                        .then((datosRespuesta)=>{
                            console.log('Respuesta del borrado:', datosRespuesta);
                            this.consultarResponsables(); 
                            this.codigoAEliminar = ''; 
                        })
                        .catch(error => {
                            console.error('Error al borrar responsable:', error);
                        });
                    }
                } else {
                    alert(`No se encontró un responsable con el código: ${codigo} o el registro no tiene ID.`);
                }
            }
        }
    }
</script>

<style scoped>
/* Estilos para la nueva interfaz */
#app-layout {
    /* Permitir que el contenido principal haga scroll si es necesario */
    display: flex;
    min-height: 100vh; 
}
.sidebar {
    width: 250px;
    background-color: #f8f9fa !important; /* Gris claro/blanco */
    height: 100vh; /* Ocupa la altura completa de la ventana */
    position: sticky; 
    top: 0;
    overflow-y: auto; /* Permite scroll si hay muchos ítems */
}
.sidebar a {
    color: #212529 !important; 
}
.active-link {
    background-color: #007bff;
    border-radius: 5px;
}
.active-link a {
    color: white !important;
    font-weight: bold;
}
.main-content {
    background-color: #f4f5f7; 
    padding-bottom: 50px !important; /* Espacio extra abajo */
}
/* Centrar la tabla y contenido principal */
.main-container {
    max-width: 1200px; 
    margin: 0 auto; 
}
h1 {
    color: #007bff;
}
.create-update-btn {
    background-color: #9c27b0;
    border-color: #9c27b0;
    width: 300px;
    font-weight: bold;
}
.eliminar-container {
    background-color: #fff3f5;
    border: 1px solid #dc3545 !important;
    max-width: 600px; 
}
.eliminar-btn {
    width: 150px;
    font-weight: bold;
}
</style>