<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Formulario para editar Ubicación</div>
      <div class="card-body">
        <form action="" v-on:submit.prevent="actualizarRegistro">
          <div class="mb-3">
            <label for="codigo_asignado" class="form-label">Código Asignado</label>
            <input
              type="text"
              required
              class="form-control"
              name="codigo_asignado"
              id="codigo_asignado"
              v-model="ubicacion.codigo_asignado"
              @input="agregarPrefijo"
            />
          </div>
          <div class="mb-3">
            <label for="nombre_ubicacion" class="form-label">Nombre de la Ubicación</label>
            <input
              type="text"
              required
              class="form-control"
              name="nombre_ubicacion"
              id="nombre_ubicacion"
              v-model="ubicacion.nombre_ubicacion"
              @input="agregarPrefijo"
            />
          </div>
          <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación Física</label>
            <input
              type="text"
              class="form-control"
              name="ubicacion"
              id="ubicacion"
              v-model="ubicacion.ubicacion"
            />
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input
              type="number"
              class="form-control"
              name="telefono"
              id="telefono"
              v-model="ubicacion.telefono"
            />
          </div>

          <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-success px-4">
                💾 Guardar Cambios
            </button>
            <router-link
                :to="{ name: 'UbicacionesView' }"
                class="btn btn-outline-danger px-4"
            >
                ❌ Cancelar
            </router-link>
            </div>
        </form>
      </div>

      <div class="card-footer text-muted">
        @IngdeSw
      </div>

    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ubicacion: {}
    }
  },
  created: function () {
    this.obtenerUbicacionID()
  },
  methods: {
    obtenerUbicacionID() {
      const idUbicacion = this.$route.params.id
      fetch(`http://localhost/sist_gestion/index.php?resource=ubicaciones&consultar=${idUbicacion}`)
        .then(respuesta => respuesta.json())
        .then((datosRespuesta) => {
          console.log(datosRespuesta)
          if (Array.isArray(datosRespuesta) && datosRespuesta.length > 0) {
            this.ubicacion = datosRespuesta[0]
          } else if (typeof datosRespuesta === 'object' && datosRespuesta !== null && datosRespuesta.id) {
            this.ubicacion = datosRespuesta
          }
          this.ubicacion.id = idUbicacion
        })
        .catch(console.error)
    },
    agregarPrefijo() {
        if (!this.ubicacion.codigo_asignado.startsWith("UB-")) {
        this.ubicacion.codigo_asignado = "UB-" + this.ubicacion.codigo_asignado.replace(/^UB-/, "");
        }
    },
    actualizarRegistro() {
      console.log(this.ubicacion)
      let datosEnviar = {
        id: this.$route.params.id,
        codigo_asignado: this.ubicacion.codigo_asignado,
        nombre_ubicacion: this.ubicacion.nombre_ubicacion,
        ubicacion: this.ubicacion.ubicacion,
        telefono: this.ubicacion.telefono
      }
      fetch(`http://localhost/sist_gestion/index.php?resource=ubicaciones&actualizar=${this.$route.params.id}`, {
        method: 'POST',
        body: JSON.stringify(datosEnviar)
      })
        .then(respuesta => respuesta.json())
        .then(datosRespuesta => {
          console.log(datosRespuesta)
          this.$router.push({ name: 'UbicacionesView' })
        })
        .catch(console.error)
    }
  }
}
</script>
