<template>
  <div class="container">
    <div class="card">
      <div class="card-header">Formulario para Crear Ubicación</div>
      <div class="card-body">
        <form @submit.prevent="crearRegistro">

          <div class="mb-3">
            <label for="codigo_asignado" class="form-label">Código Asignado</label>
            <input
              type="text"
              required
              class="form-control"
              id="codigo_asignado"
              v-model="ubicacion.codigo_asignado"
            />
            <div v-if="errorCodigo" class="text-danger mt-1">
              {{ errorCodigo }}
            </div>
          </div>

          <div class="mb-3">
            <label for="nombre_ubicacion" class="form-label">Nombre de la Ubicación</label>
            <input
              type="text"
              required
              class="form-control"
              id="nombre_ubicacion"
              v-model="ubicacion.nombre_ubicacion"
            />
          </div>

          <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación</label>
            <input
              type="text"
              required
              class="form-control"
              id="ubicacion"
              v-model="ubicacion.ubicacion"
            />
          </div>

          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input
              type="text"
              class="form-control"
              id="telefono"
              v-model="ubicacion.telefono"
            />
          </div>

          <div class="btn-group">
            <!-- type="submit" para disparar crearRegistro -->
            <button 
              type="submit"
              class="btn btn-success"
            >
              Guardar
            </button>

            <router-link :to="{ name: 'UbicacionesView' }" class="btn btn-danger">
              Cancelar
            </router-link>
          </div>
        </form>
      </div>
      <div class="card-footer text-muted">@IngdeSw</div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      ubicacion: {
        codigo_asignado: "",
        nombre_ubicacion: "", // <-- inicializado con el nombre que espera el backend
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
  if (!codigo) return false; // vacío no validamos aquí

  try {
    const response = await fetch(
      `http://localhost/sist_gestion/index.php?resource=ubicaciones&codigo=${encodeURIComponent(codigo)}`
    );

    const datos = await response.json();

    // datos es un objeto vacío si no existe
    if (datos && typeof datos === 'object' && Object.keys(datos).length > 0) {
      // Verificamos que el código coincida exactamente
      if (datos.codigo_asignado === codigo) {
        this.errorCodigo = "⚠️ Este código ya está registrado.";
        return true; // existe
      } else {
        this.errorCodigo = null;
        return false; // no existe
      }
    } else {
      this.errorCodigo = null;
      return false; // no existe
    }
  } catch (error) {
    console.error("Error al validar el código:", error);
    this.errorCodigo = "❌ Error al validar el código.";
    return true; // prevenimos el guardado si hay error
  }
},


  // Crear registro
  async crearRegistro() {
    // 1️⃣ Validación de campos vacíos
    if (
      !this.ubicacion.codigo_asignado.trim() ||
      !this.ubicacion.nombre_ubicacion.trim() ||
      !this.ubicacion.ubicacion.trim()
    ) {
      alert("Por favor, complete todos los campos obligatorios.");
      return;
    }

    // 2️⃣ Validación de código duplicado antes de guardar
    const existeCodigo = await this.validarCodigo();
    if (existeCodigo) {
      alert("Corrija el código asignado antes de guardar.");
      return;
    }

    // 3️⃣ Guardar en la base de datos
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
