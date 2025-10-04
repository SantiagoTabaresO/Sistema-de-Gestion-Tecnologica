<template>
  <div class="dashboard-container">
    <div class="main-content">
      <!-- Encabezado -->
      <div class="header">
        <h1>
          <span><i class="fas fa-plus-circle"></i></span> Crear Equipo Médico
        </h1>
      </div>

      <!-- Formulario -->
      <div class="table-container">
        <form @submit.prevent="crearRegistro" class="form-content">
          <div class="form-group">
            <label for="numero_activo">Número de Activo</label>
            <input type="text" id="numero_activo" v-model="equipo.numero_activo" required />
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
              <i class="fas fa-save"></i> Guardar
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
      equipo: {
        numero_activo: "",
        marca: "",
        modelo: "",
        codigo_ubicacion: "",
        codigo_responsable: ""
      },
      ubicaciones: [],
      responsables: [],
      equiposExistentes: []
    };
  },
  computed: {
    formularioValido() {
      const e = this.equipo;
      return (
        e.numero_activo.trim() &&
        e.marca.trim() &&
        e.modelo.trim() &&
        e.codigo_ubicacion.trim() &&
        e.codigo_responsable.trim()
      );
    }
  },
  created() {
    this.cargarUbicaciones();
    this.cargarResponsables();
    this.cargarEquiposExistentes();
  },
  methods: {
    async cargarUbicaciones() {
      try {
        const res = await fetch("http://localhost/equipos/index.php?resource=ubicaciones");
        this.ubicaciones = await res.json();
      } catch (err) {
        console.error("Error cargando ubicaciones", err);
      }
    },
    async cargarResponsables() {
      try {
        const res = await fetch("http://localhost/equipos/index.php?resource=responsables");
        this.responsables = await res.json();
      } catch (err) {
        console.error("Error cargando responsables", err);
      }
    },
    async cargarEquiposExistentes() {
      try {
        const res = await fetch("http://localhost/equipos/index.php?resource=equipos");
        const data = await res.json();
        this.equiposExistentes = Array.isArray(data) ? data : [];
      } catch (err) {
        console.error("Error cargando equipos existentes", err);
      }
    },
    async crearRegistro() {
      const duplicado = this.equiposExistentes.find(
        eq => eq.numero_activo.toLowerCase() === this.equipo.numero_activo.trim().toLowerCase()
      );

      if (duplicado) {
        alert("❌ El número de activo ya existe. Por favor ingrese uno diferente.");
        return;
      }

      try {
        const respuesta = await fetch(
          "http://localhost/equipos/index.php?resource=equipos&insertar=1",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.equipo)
          }
        );

        const datosRespuesta = await respuesta.json();
        if (datosRespuesta && Number(datosRespuesta.success) === 1) {
          alert("✅ Equipo creado con éxito.");
          this.$router.push({ name: "EquiposView" });
        } else {
          alert("❌ Error al crear el equipo.");
        }
      } catch (error) {
        console.error("Error creando registro:", error);
        alert("❌ Error al crear el equipo.");
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