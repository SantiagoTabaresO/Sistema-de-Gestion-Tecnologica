<template>
    <div class="container">

        <div class="card">
            <div class="card-header"><h2>Listar Responsables</h2></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-secundary">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Código Asignado</th>
                                <th scope="col">Documento Identidad</th>
                                <th scope="col">Nombre Completo</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="responsable in responsables" v-bind:key="responsable.id">
                                <td>{{ responsable.id }}</td>
                                <td>{{ responsable.codigo_asignado }}</td>
                                <td>{{ responsable.documento_identidad }}</td>
                                <td>{{ responsable.nombre_apellidos }}</td>
                                <td>{{ responsable.cargo }}</td>
                                <td>{{ responsable.telefono }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Button group name">
                                        <router-link :to="{name:'EditarRespView', params:{id:responsable.id}}" class="btn btn-success">Editar</router-link>
                                        <button type="button" v-on:click="borrarResponsable(responsable.id)" class="btn btn-danger">Borrar </button>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="card-footer text-muted">@SyncLab</div>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return{
                responsables: [] // Inicializado como array vacío para el v-for
            }
        },
        created:function(){
            this.consultarResponsables();
        },
        methods:{
            consultarResponsables(){
                fetch('http://localhost/sist_gestion/index.php?resource=responsables')
                .then(respuesta => respuesta.json())
                .then((datosRespuesta)=>{
                    console.log(datosRespuesta)
                    
                    // LÓGICA CORREGIDA PARA MANEJAR DIVERSOS FORMATOS DE RESPUESTA:
                    
                    // 1. Verifica si la respuesta es un array (formato directo)
                    if(Array.isArray(datosRespuesta)){
                        this.responsables = datosRespuesta;
                    } 
                    // 2. Verifica si la respuesta es un objeto y la data está anidada (formato común en APIs)
                    else if(datosRespuesta && (datosRespuesta.datos || datosRespuesta.responsables) && Array.isArray(datosRespuesta.datos || datosRespuesta.responsables)){
                        this.responsables = datosRespuesta.datos || datosRespuesta.responsables;
                    }
                    // 3. Verifica si la respuesta es un objeto que contiene una propiedad 'success' pero también los datos (formato del código original)
                    else if(typeof datosRespuesta[0] === 'object' && typeof datosRespuesta[0].success === 'undefined'){
                        this.responsables = datosRespuesta;
                    }
                    
                    // Si después de todas las verificaciones sigue sin ser un array, se queda vacío y no se muestra nada.

                })
                .catch(error => {
                    console.error('Error al consultar responsables:', error);
                })
            },
            borrarResponsable(id){
                console.log('Intentando borrar responsable con ID:', id);
                // Se mantiene la URL de borrado, asumiendo que el backend maneja la acción
                fetch(`http://localhost/sist_gestion/index.php?resource=responsables&borrar=${id}`)
                .then(respuesta => respuesta.json())
                .then((datosRespuesta)=>{
                    console.log('Respuesta del borrado:', datosRespuesta)
                    // Una vez que se borra, se vuelve a consultar la lista para actualizar la vista
                    this.consultarResponsables(); 
                    // Se reemplaza window.location.href="ListarView" por la recarga de datos para una mejor experiencia de usuario.
                })
                .catch(error => {
                    console.error('Error al borrar responsable:', error);
                })
            }
        }
    }
</script>