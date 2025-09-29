<template>
  <div class="dashboard-container">
    
    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <h1><span><i class="fas fa-user-tag"></i></span> Responsables por equipo</h1>
      </div>

      <!-- Search -->
      <div class="search-bar">
        <input
          type="text"
          v-model="busqueda"
          placeholder="Buscar por nombre, documento de identidad o código asignado 🔍"
        />
      </div>

      <!-- Table -->
      <div class="table-container">
        <h2>Listado de Responsables ({{ responsables.length }} registros)</h2>
        <table class="data-table">
          <thead>
            <tr>
              <th>Código</th>
              <th>Documento de identidad</th>
              <th>Nombre y apellidos</th>
              <th>Cargo</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="responsable in responsablesFiltrados" :key="responsable.id">
              <td>{{ responsable.codigo_asignado }}</td>
              <td>{{ responsable.documento_identidad }}</td>
              <td>{{ responsable.nombre_apellidos }}</td>
              <td>{{ responsable.cargo }}</td>
              <td>{{ responsable.telefono }}</td>
              <td>
                <router-link
                  :to="{ name: 'EditarRespView', params: { id: responsable.id }}"
                  class="btn btn-sm btn-outline-secondary"
                >
                  Editar
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>

        <div v-if="responsablesFiltrados.length === 0" class="text-center p-4 text-muted">
          No se encontraron responsables.
        </div>
      </div>

      <!-- Actions -->
      <div class="action-section">
        <router-link :to="{ name: 'EditarRespView' }" class="btn btn-purple">
          <i class="fas fa-plus"></i> CREAR REGISTRO
        </router-link>

        <div class="delete-area">
          <label for="codigo-eliminar">
            Escriba el <strong>código</strong> asignado del registro a
            <span class="text-danger">ELIMINAR</span>:
          </label>
          <input
            type="text"
            id="codigo-eliminar"
            v-model="codigoAEliminar"
            placeholder="Ej: R-001"
          />
          <button
            class="btn btn-red"
            @click="borrarResponsablePorCodigo"
            :disabled="!codigoAEliminar"
          >
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
      responsables: [],
      codigoAEliminar: '',
      busqueda: ''
    }
  },
  created() {
    this.consultarResponsables()
  },
  computed: {
    responsablesFiltrados() {
      if (!this.busqueda) return this.responsables
      const filtro = this.busqueda.toLowerCase()
      return this.responsables.filter(r =>
        r.nombre_apellidos.toLowerCase().includes(filtro) ||
        r.documento_identidad.toLowerCase().includes(filtro) ||
        r.codigo_asignado.toLowerCase().includes(filtro)
      )
    }
  },
  methods: {
    consultarResponsables() {
      fetch('http://localhost/sist_gestion/index.php?resource=responsables')
        .then(res => res.json())
        .then(data => {
          if (Array.isArray(data)) {
            this.responsables = data
          } else {
            this.responsables = []
          }
        })
        .catch(err => console.error('Error al consultar responsables:', err))
    },
    borrarResponsablePorCodigo() {
      const codigo = this.codigoAEliminar
      if (!codigo) return
      const responsable = this.responsables.find(r => r.codigo_asignado === codigo)
      if (responsable && responsable.id) {
        if (confirm(`¿Está seguro de eliminar al responsable con código ${codigo}?`)) {
          fetch(`http://localhost/sist_gestion/index.php?resource=responsables&borrar=${responsable.id}`)
            .then(res => res.json())
            .then(() => {
              this.consultarResponsables()
              this.codigoAEliminar = ''
            })
            .catch(err => console.error('Error al borrar responsable:', err))
        }
      } else {
        alert(`No se encontró un responsable con el código: ${codigo}`)
      }
    }
  }
}
</script>

<style scoped>
/* --------- Estructura General --------- */
.dashboard-container {
  display: flex;
  min-height: 100vh;
  background-color: #f4f7f6;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* --------- Sidebar --------- */
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

/* --------- Main Content --------- */
.main-content {
  flex-grow: 1;
  padding: 30px;
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
  font-size: 0.8em;
  margin-right: 15px;
  color: #1abc9c;
}

/* --------- Search Bar --------- */
.search-bar {
  margin-bottom: 20px;
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

/* --------- Table --------- */
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

/* --------- Actions --------- */
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
