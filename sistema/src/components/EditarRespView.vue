<template>
  <div class="dashboard-container">
    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1>
          <span><i class="fas fa-user-edit"></i></span> Editar Responsable
        </h1>
      </div>

      <!-- Formulario -->
      <div class="form-container">
        <form @submit.prevent="actualizarRegistro" class="edit-form">
          
          <!-- Código Asignado -->
          <div class="form-group">
            <label for="codigo_asignado">Código Asignado</label>
            <input
              type="text"
              required
              id="codigo_asignado"
              v-model="responsable.codigo_asignado"
              @input="agregarPrefijo"
            />
          </div>

          <!-- Documento Identidad -->
          <div class="form-group">
            <label for="documento_identidad">Documento Identidad</label>
            <input
              type="number"
              required
              id="documento_identidad"
              v-model="responsable.documento_identidad"
              min="0"
            />
          </div>

          <!-- Nombre Completo -->
          <div class="form-group">
            <label for="nombre_apellidos">Nombre Completo</label>
            <input
              type="text"
              required
              id="nombre_apellidos"
              v-model="responsable.nombre_apellidos"
            />
          </div>

          <!-- Cargo -->
          <div class="form-group">
            <label for="cargo">Cargo</label>
            <input
              type="text"
              id="cargo"
              v-model="responsable.cargo"
            />
          </div>

          <!-- Teléfono -->
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input
              type="number"
              id="telefono"
              v-model="responsable.telefono"
            />
          </div>

          <!-- Botones -->
          <div class="form-actions">
            <button type="submit" class="btn btn-green">
              <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <router-link
              :to="{ name: 'responsablesView' }"
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
      responsable: {
        codigo_asignado: "",
        documento_identidad: "",
        nombre_apellidos: "",
        cargo: "",
        telefono: ""
      }
    };
  },
  created() {
    this.obtenerResponsableID();
  },
  methods: {
    obtenerResponsableID() {
      const idResponsable = this.$route.params.id;

      fetch(
        `http://localhost/sist_gestion/index.php?resource=responsables&consultar=${idResponsable}`
      )
        .then((respuesta) => respuesta.json())
        .then((datosRespuesta) => {
          if (Array.isArray(datosRespuesta) && datosRespuesta.length > 0) {
            this.responsable = datosRespuesta[0];
          } else if (
            typeof datosRespuesta === "object" &&
            datosRespuesta !== null &&
            datosRespuesta.id
          ) {
            this.responsable = datosRespuesta;
          }
          this.responsable.id = idResponsable;
        })
        .catch(console.error);
    },
    agregarPrefijo() {
      if (!this.responsable.codigo_asignado.startsWith("R-")) {
        this.responsable.codigo_asignado =
          "R-" + this.responsable.codigo_asignado.replace(/^R-/, "");
      }
    },
    actualizarRegistro() {
      let datosEnviar = {
        id: this.$route.params.id,
        codigo_asignado: this.responsable.codigo_asignado,
        documento_identidad: this.responsable.documento_identidad,
        nombre_apellidos: this.responsable.nombre_apellidos,
        cargo: this.responsable.cargo,
        telefono: this.responsable.telefono
      };

      fetch(
        `http://localhost/sist_gestion/index.php?resource=responsables&actualizar=${this.$route.params.id}`,
        {
          method: "POST",
          body: JSON.stringify(datosEnviar)
        }
      )
        .then((respuesta) => respuesta.json())
        .then(() => {
          this.$router.push({ name: "responsablesView" });
        })
        .catch(console.error);
    }
  }
};
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
