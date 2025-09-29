<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Editar Responsable</h5>
          </div>

          <div class="card-body">
            <form v-on:submit.prevent="actualizarRegistro">
              
              <div class="mb-3">
                <label for="codigo_asignado" class="form-label">Código Asignado</label>
                <input
                    type="text"
                    required
                    class="form-control"
                    id="codigo_asignado"
                    v-model="responsable.codigo_asignado"
                    @input="agregarPrefijo"
                />
                </div>


              <div class="mb-3">
                <label for="documento_identidad" class="form-label">Documento Identidad</label>
                <input
                    type="number"
                    required
                    class="form-control"
                    id="documento_identidad"
                    v-model="responsable.documento_identidad"
                    min="0"
                />
                </div>


              <div class="mb-3">
                <label for="nombre_apellidos" class="form-label">Nombre Completo</label>
                <input
                  type="text"
                  required
                  class="form-control"
                  id="nombre_apellidos"
                  v-model="responsable.nombre_apellidos"
                />
              </div>

              <div class="mb-3">
                <label for="cargo" class="form-label">Cargo</label>
                <input
                  type="text"
                  class="form-control"
                  id="cargo"
                  v-model="responsable.cargo"
                />
              </div>

              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input
                  type="number"
                  class="form-control"
                  id="telefono"
                  v-model="responsable.telefono"
                />
              </div>

              <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-success px-4">
                  💾 Guardar Cambios
                </button>
                <router-link
                  :to="{ name: 'responsablesView' }"
                  class="btn btn-outline-danger px-4"
                >
                  ❌ Cancelar
                </router-link>
              </div>
            </form>
          </div>

          <div class="card-footer text-muted text-end">
            @IngdeSw
          </div>
        </div>

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
  created: function () {
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
        this.responsable.codigo_asignado = "R-" + this.responsable.codigo_asignado.replace(/^R-/, "");
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
