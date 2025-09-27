<template>
    <div class="container">

        <div class="card">
            <div class="card-header">Formulario para editar Responsable</div>
            <div class="card-body">
                <form action="" v-on:submit.prevent="actualizarRegistro">
                    <div class="mb-3">
                        <label for="codigo_asignado" class="form-label">Código Asignado</label>
                        <input type="text" required class="form-control" name="codigo_asignado" id="codigo_asignado" 
                               v-model="responsable.codigo_asignado"/>
                    </div>

                    <div class="mb-3">
                        <label for="documento_identidad" class="form-label">Documento Identidad</label>
                        <input type="text" required class="form-control" name="documento_identidad" id="documento_identidad" 
                               v-model="responsable.documento_identidad"/>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_apellidos" class="form-label">Nombre Completo</label>
                        <input type="text" required class="form-control" name="nombre_apellidos" id="nombre_apellidos" 
                               v-model="responsable.nombre_apellidos"/>
                    </div>

                    <div class="mb-3">
                        <label for="cargo" class="form-label">Cargo</label>
                        <input type="text" class="form-control" name="cargo" id="cargo" 
                               v-model="responsable.cargo"/>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" 
                               v-model="responsable.telefono"/>
                    </div>


                    <div class="btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <router-link :to="{name:'ResponsablesView'}" class="btn btn-danger">Cancelar</router-link>
                    </div>

                </form> 
            </div>
            <div class="card-footer text-muted">@IngdeSw</div>
        </div>
        
    </div>
</template>

<script>
    export default{
        data(){
            return{
                // CAMBIADO: La variable de estado ahora es 'responsable'
                responsable:{} 
            }
        },
        created:function(){
            // CAMBIADO: Llamar al método de obtención del responsable
            this.obtenerResponsableID()
        },
        methods:{
            // CAMBIADO: Renombrado y ajustada la URL de consulta
            obtenerResponsableID(){
                const idResponsable = this.$route.params.id;

                // URL: Se apunta al endpoint de responsables y se usa 'consultar'
                fetch(`http://localhost/ResponsablesView/?consultar=${idResponsable}`)
                .then(respuesta=>respuesta.json())
                .then((datosRespuesta)=>{
                    console.log(datosRespuesta)
                    
                    // Manejo de respuesta: El backend PHP devuelve un array de un solo objeto.
                    // Si el backend se corrigió (como se sugirió), devuelve el array de 1 item.
                    if(Array.isArray(datosRespuesta) && datosRespuesta.length > 0){
                         this.responsable = datosRespuesta[0]
                    } else if (typeof datosRespuesta === 'object' && datosRespuesta !== null && datosRespuesta.id) {
                         // Si por alguna razón devuelve el objeto directamente
                         this.responsable = datosRespuesta
                    }

                    // Aseguramos que la propiedad id esté presente en el objeto
                    this.responsable.id = idResponsable; 

                })
                .catch(console.error)
            },
            // CAMBIADO: Renombrado y ajustada la lógica de datos a enviar
            actualizarRegistro(){
                console.log(this.responsable)
                
                // CAMBIADO: Los datos a enviar reflejan los 5 campos de la tabla 'responsables'
                let datosEnviar = {
                    id: this.$route.params.id,
                    codigo_asignado: this.responsable.codigo_asignado,
                    documento_identidad: this.responsable.documento_identidad, // Nota: el input V-Model debe coincidir con la clave JSON
                    nombre_apellidos: this.responsable.nombre_apellidos,
                    cargo: this.responsable.cargo,
                    telefono: this.responsable.telefono
                }

                // URL: Se apunta al endpoint de responsables y se usa 'actualizar'
                fetch(`http://localhost/ResponsablesView/?actualizar=${this.$route.params.id}`,{
                    method:'POST',
                    body:JSON.stringify(datosEnviar)
                })
                .then(respuesta=>respuesta.json())
                .then(datosRespuesta=>{
                    console.log(datosRespuesta);
                    // Navegar de vuelta a la vista de listado
                    this.$router.push({name:'ResponsablesView'}); 

                })
                .catch(console.error)
            }
        }
    }
</script>