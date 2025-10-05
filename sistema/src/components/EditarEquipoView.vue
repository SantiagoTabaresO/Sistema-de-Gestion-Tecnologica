<template>
  <div class="dashboard-container">
    <div class="main-content">
      <!-- Encabezado -->
      <div class="header">
        <h1>
          <span><i class="fas fa-edit"></i></span> Editar Equipo Médico
        </h1>
      </div>

      <!-- Formulario -->
      <div class="table-container">
        <form @submit.prevent="actualizarRegistro" class="form-content">
          <div class="form-group">
            <label for="numero_activo">Número de Activo</label>
            <input type="text" id="numero_activo" v-model="equipo.numero_activo" disabled />
          </div>

          <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" id="marca" v-model="equipo.marca" required />
          </div>

          <div class="form-group">
            <label for="modelo">Modelo</label>
            <input type="text" id="modelo" v-model="equipo.modelo" required />
          </div>

          <div class="form-group">
            <label for="codigo_ubicacion">Ubicación</label>
            <select id="codigo_ubicacion" v-model="equipo.codigo_ubicacion" required>
              <option disabled value="">Seleccione una ubicación</option>
              <option v-for="ubi in ubicaciones" :key="ubi.id" :value="ubi.codigo_asignado">
                {{ ubi.nombre_ubicacion }} - {{ ubi.ubicacion }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="codigo_responsable">Responsable</label>
            <select id="codigo_responsable" v-model="equipo.codigo_responsable" required>
              <option disabled value="">Seleccione un responsable</option>
              <option v-for="resp in responsables" :key="resp.id" :value="resp.codigo_asignado">
                {{ resp.nombre_apellidos }} - {{ resp.cargo }}
              </option>
            </select>
          </div>

          <div class="button-group">
            <button type="submit" class="btn btn-purple">
              <i class="fas fa-save"></i> Guardar Cambios
            </button>
            <router-link :to="{ name: 'EquiposView' }" class="btn btn-red">
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
      equipo: {},
      ubicaciones: [],
      responsables: []
    };
  },
  created() {
    this.obtenerEquipoID();
    this.cargarUbicaciones();
    this.cargarResponsables();
  },
  methods: {
    async obtenerEquipoID() {
      const idEquipo = this.$route.params.id;
      try {
        const res = await fetch(
          `http://localhost/sist_gestion/index.php?resource=equipos&consultar=${idEquipo}`
        );
        const datosRespuesta = await res.json();
        if (datosRespuesta && datosRespuesta.id) {
          this.equipo = datosRespuesta;
        }
        this.equipo.id = idEquipo;
      } catch (err) {
        console.error("Error obteniendo equipo:", err);
      }
    },
    agregarPrefijo() {
      if (!this.equipo.codigo_asignado.startsWith("U")) {
        this.equipo.codigo_asignado = "U" + this.equipo.codigo_asignado.replace(/^U/, "")
      }
    },
    
    async cargarUbicaciones() {
      try {
        const res = await fetch("http://localhost/sist_gestion/index.php?resource=ubicaciones");
        this.ubicaciones = await res.json();
      } catch (err) {
        console.error("Error cargando ubicaciones", err);
      }
    },
    async cargarResponsables() {
      try {
        const res = await fetch("http://localhost/sist_gestion/index.php?resource=responsables");
        this.responsables = await res.json();
      } catch (err) {
        console.error("Error cargando responsables", err);
      }
    },
    async actualizarRegistro() {
      const datosEnviar = {
        id: this.$route.params.id,
        numero_activo: this.equipo.numero_activo,
        marca: this.equipo.marca,
        modelo: this.equipo.modelo,
        codigo_ubicacion: this.equipo.codigo_ubicacion,
        codigo_responsable: this.equipo.codigo_responsable
      };

      try {
        const res = await fetch(
          `http://localhost/sist_gestion/index.php?resource=equipos&actualizar=${this.$route.params.id}`,
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datosEnviar)
          }
        );
        const datosRespuesta = await res.json();
        if (datosRespuesta && datosRespuesta.success == 1) {
          alert("✅ Equipo actualizado correctamente");
          this.$router.push({ name: "EquiposView" });
        } else {
          alert("❌ Error al actualizar el equipo");
        }
      } catch (err) {
        console.error("Error actualizando equipo:", err);
        alert("❌ Error al actualizar el equipo");
      }
    }
  }
};
</script>

<style scoped>
.page-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f4f7f6;
}

.form-card {
  background-color: white;
  padding: 40px 50px;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 650px;
}

.form-title {
  text-align: center;
  font-size: 2.2em;
  color: #2c3e50;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  margin-bottom: 35px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}
.form-title i {
  color: #8e44ad;
  font-size: 1em;
}

.form-content {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.form-group {
  display: flex;
  flex-direction: column;
}
label {
  font-weight: 600;
  color: #34495e;
  margin-bottom: 6px;
}
input,
select {
  padding: 10px 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 1em;
  outline: none;
  transition: border-color 0.3s;
}
input:focus,
select:focus {
  border-color: #8e44ad;
}

.button-group {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 35px;
}
.btn {
  padding: 14px 30px;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
  text-decoration: none;
  display: flex;
  align-items: center;
  gap: 8px;
  border: none;
  font-size: 1.05em;
}
.btn-purple {
  background-color: #8e44ad;
  color: white;
}
.btn-purple:hover {
  background-color: #9b59b6;
}
.btn-red {
  background-color: #e74c3c;
  color: white;
}
.btn-red:hover {
  background-color: #c0392b;
}

</style>
