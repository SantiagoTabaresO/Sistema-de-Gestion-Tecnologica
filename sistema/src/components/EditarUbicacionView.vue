<template>
  <div class="dashboard-container">
    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1>
          <span><i class="fas fa-map-marker-alt"></i></span> Editar Ubicación
        </h1>
      </div>

      <!-- Formulario -->
      <div class="form-container">
        <form @submit.prevent="actualizarRegistro" class="edit-form">
          <!-- Código asignado -->
          <div class="form-group">
            <label for="codigo_asignado">Código Asignado</label>
            <input
              type="text"
              required
              id="codigo_asignado"
              v-model="ubicacion.codigo_asignado"
              @input="agregarPrefijo"
            />
          </div>

          <!-- Nombre ubicación -->
          <div class="form-group">
            <label for="nombre_ubicacion">Nombre de la Ubicación</label>
            <input
              type="text"
              required
              id="nombre_ubicacion"
              v-model="ubicacion.nombre_ubicacion"
            />
          </div>

          <!-- Ubicación física -->
          <div class="form-group">
            <label for="ubicacion">Ubicación Física</label>
            <input
              type="text"
              id="ubicacion"
              v-model="ubicacion.ubicacion"
            />
          </div>

          <!-- Teléfono -->
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input
              type="number"
              id="telefono"
              v-model="ubicacion.telefono"
            />
          </div>

          <!-- Botones -->
          <div class="form-actions">
            <button type="submit" class="btn btn-green">
              <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <router-link
              :to="{ name: 'UbicacionesView' }"
              class="btn btn-red-outline"
            >
              <i class="fas fa-times"></i> Cancelar
            </router-link>
          </div>
        </form>
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
  created() {
    this.obtenerUbicacionID()
  },
  methods: {
    obtenerUbicacionID() {
      const idUbicacion = this.$route.params.id
      fetch(`http://localhost/sist_gestion/index.php?resource=ubicaciones&consultar=${idUbicacion}`)
        .then(respuesta => respuesta.json())
        .then((datosRespuesta) => {
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
      if (!this.ubicacion.codigo_asignado.startsWith("U")) {
        this.ubicacion.codigo_asignado = "U" + this.ubicacion.codigo_asignado.replace(/^U/, "")
      }
    },
    actualizarRegistro() {
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
        .then(() => {
          this.$router.push({ name: 'UbicacionesView' })
        })
        .catch(console.error)
    }
  }
}
</script>

<style scoped>
.dashboard-container {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex-grow: 1;
  padding: 30px;
  background-color:#f4f7f6;
}

.header {
  margin-bottom: 30px;
}

.header h1 {
  font-size: 2.2em;
  color:#2c3e50;
  display: flex;
  align-items: center;
  margin: 0;
}

.header h1 span {
  font-weight: normal;
  font-size: 0.9em;
  margin-right: 15px;
  color:#1abc9c;
}

/* Formulario */
.form-container {
  background:#fff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 6pxrgba(0,0,0,0.1);
}

.form-container h2 {
  margin-bottom: 20px;
  color:#2c3e50;
  font-size: 1.5em;
}

.edit-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 600;
  margin-bottom: 6px;
  color: #333;
}

.form-group input {
  padding: 10px;
  border: 1px solid#ccc;
  border-radius: 5px;
  font-size: 1em;
}

/* Botones */
.form-actions {
  display: flex;
  gap: 15px;
  margin-top: 20px;
}

.btn {
  padding: 12px 20px;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-green {
  background-color:#27ae60;
  color:#fff;
  border: none;
}

.btn-green:hover {
  background-color:#2ecc71;
}

.btn-red-outline {
  background: none;
  border: 2px solid#e74c3c;
  color:#e74c3c;
}

.btn-red-outline:hover {
  background-color:#e74c3c;
  color:#fff;
}
</style>
