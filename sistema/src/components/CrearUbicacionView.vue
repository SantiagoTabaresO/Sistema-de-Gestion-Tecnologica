<template>
  <div class="dashboard-container">
    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1>
          <span><i class="fas fa-map-marker-alt"></i></span> Crear Ubicación
        </h1>
      </div>

      <!-- Formulario -->
      <div class="form-container">
        <h2>Formulario de creación</h2>
        <form @submit.prevent="crearRegistro" class="edit-form">
          
          <!-- Código Asignado -->
          <div class="form-group">
            <label for="codigo_asignado">Código Asignado</label>
            <input
              type="text"
              required
              id="codigo_asignado"
              v-model="ubicacion.codigo_asignado"
            />
            <div v-if="errorCodigo" class="error-text">
              {{ errorCodigo }}
            </div>
          </div>

          <!-- Nombre Ubicación -->
          <div class="form-group">
            <label for="nombre_ubicacion">Nombre de la Ubicación</label>
            <input
              type="text"
              required
              id="nombre_ubicacion"
              v-model="ubicacion.nombre_ubicacion"
            />
          </div>

          <!-- Ubicación -->
          <div class="form-group">
            <label for="ubicacion">Ubicación</label>
            <input
              type="text"
              required
              id="ubicacion"
              v-model="ubicacion.ubicacion"
            />
          </div>

          <!-- Teléfono -->
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input
              type="text"
              id="telefono"
              v-model="ubicacion.telefono"
            />
          </div>

          <!-- Botones -->
          <div class="form-actions">
            <button type="submit" class="btn btn-green">
              <i class="fas fa-save"></i> Guardar
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
      ubicacion: {
        codigo_asignado: "",
        nombre_ubicacion: "",
        ubicacion: "",
        telefono: ""
      },
      errorCodigo: null
    }
  },
  methods: {
    // Validación de código duplicado
    async validarCodigo() {
      const codigo = this.ubicacion.codigo_asignado.trim();
      if (!codigo) return false;

      try {
        const response = await fetch(
          `http://localhost/sist_gestion/index.php?resource=ubicaciones&codigo=${encodeURIComponent(codigo)}`
        );
        const datos = await response.json();

        if (datos && typeof datos === 'object' && Object.keys(datos).length > 0) {
          if (datos.codigo_asignado === codigo) {
            this.errorCodigo = "Este código ya está registrado.";
            return true;
          } else {
            this.errorCodigo = null;
            return false;
          }
        } else {
          this.errorCodigo = null;
          return false;
        }
      } catch (error) {
        console.error("Error al validar el código:", error);
        this.errorCodigo = "Error al validar el código.";
        return true;
      }
    },

    // Crear registro
    async crearRegistro() {
      if (
        !this.ubicacion.codigo_asignado.trim() ||
        !this.ubicacion.nombre_ubicacion.trim() ||
        !this.ubicacion.ubicacion.trim()
      ) {
        alert("Por favor, complete todos los campos obligatorios.");
        return;
      }

      const existeCodigo = await this.validarCodigo();
      if (existeCodigo) {
        alert("Corrija el código asignado antes de guardar.");
        return;
      }

      try {
        const respuesta = await fetch(
          "http://localhost/sist_gestion/index.php?resource=ubicaciones&insertar=1",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.ubicacion)
          }
        );

        const datosRespuesta = await respuesta.json();
        if (datosRespuesta && Number(datosRespuesta.success) === 1) {
          alert("Ubicación creada con éxito.");
          this.$router.push({ name: "UbicacionesView" });
        } else {
          const mensaje = datosRespuesta.error || "Error al crear la ubicación.";
          alert(mensaje);
        }
      } catch (error) {
        console.error("Error creando registro:", error);
        alert("Error al crear la ubicación.");
      }
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
  color:#333;
}

.form-group input {
  padding: 10px;
  border: 1px solid#ccc;
  border-radius: 5px;
  font-size: 1em;
}

.error-text {
  color:#e74c3c;
  margin-top: 5px;
  font-size: 0.9em;
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
