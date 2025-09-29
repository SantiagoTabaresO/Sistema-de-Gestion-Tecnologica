<template>
  <div class="container">
    
    <!-- Main content -->
    <main class="content">
      <h1>SGT – Sistema de Gestión Tecnológica</h1>
      <p>
        El Sistema de Gestión Tecnológica (SGT) es una aplicación web diseñada para administrar de manera eficiente la información relacionada con los equipos médicos de nuestra IPS. Su objetivo principal es garantizar un control organizado sobre las ubicaciones, los responsables y los equipos médicos, brindando accesibilidad y exactitud en los datos almacenados.
      </p>

      <div class="cards">
        <div class="card">
          <div class="card-header">Ubicaciones</div>
          <div class="card-body">
            Este módulo permite registrar y administrar todas las áreas del centro de salud donde se encuentran los equipos médicos. Facilita la organización de la información de cada ubicación, garantizando que siempre se conozca en qué lugar está asignada la tecnología.
          </div>
        </div>

        <div class="card">
          <div class="card-header">Responsables</div>
          <div class="card-body">
            En este módulo se gestiona la información del personal encargado de los equipos médicos. Permite identificar de manera clara quién tiene bajo su custodia cada dispositivo, brindando mayor control y trazabilidad dentro de la institución.
          </div>
        </div>

        <div class="card">
          <div class="card-header">Equipo médico</div>
          <div class="card-body">
            Aquí se centraliza la gestión de los equipos médicos de la IPS. El módulo permite asociar cada dispositivo a una ubicación y a un responsable, asegurando un control preciso y actualizado de la tecnología disponible en el centro de salud.
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: "HomeView"
};
</script>

<style scoped>
.home-container {
  display: flex;
  min-height: 100vh;
  background-color: #f4f7f6;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Sidebar */
.sidebar {
  width: 220px;
  background-color: #fff;
  padding: 20px;
  box-shadow: 2px 0 8px rgba(0,0,0,0.1);
}

.logo {
  font-size: 1.5em;
  font-weight: bold;
  color: #2c3e50;
  margin-bottom: 30px;
}

.menu {
  list-style: none;
  padding: 0;
}

.menu li {
  padding: 12px 0;
  cursor: pointer;
  font-weight: 500;
  color: #333;
}

.menu li.active {
  font-weight: bold;
  color: #8e44ad;
}

/* Main content */
.content {
  flex: 1;
  padding: 40px;
}

.content h1 {
  font-size: 2em;
  margin-bottom: 20px;
  color: #2c3e50;
}

.content p {
  margin-bottom: 30px;
  line-height: 1.6;
  color: #555;
}

/* Cards */
.cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
}

.card {
  background-color: #fff;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.card-header {
  font-weight: bold;
  font-size: 1.1em;
  margin-bottom: 10px;
  color: #8e44ad;
}

.card-body {
  color: #555;
  line-height: 1.5;
  font-size: 0.95em;
}
</style>
