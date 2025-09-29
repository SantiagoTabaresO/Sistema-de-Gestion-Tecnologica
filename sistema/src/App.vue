<template>
  <div id="app">
    <div class="dashboard-container">
      <!-- Sidebar -->
      <div class="sidebar">
        <h3>SyncLab</h3>
        <div class="menu">
          <router-link to="/" class="menu-item" active-class="active">
            <i class="fas fa-home"></i> Inicio
          </router-link>

          <router-link to="/UbicacionesView" class="menu-item" active-class="active">
            <i class="fas fa-map-marker-alt"></i> Ubicaciones
          </router-link>

          <router-link to="/EquipoMedicoView" class="menu-item" active-class="active">
            <i class="fas fa-medkit"></i> Equipo médico
          </router-link>

          <router-link to="/ResponsablesView" class="menu-item" active-class="active">
            <i class="fas fa-user-tag"></i> Responsables
          </router-link>
        </div>
      </div>

      <!-- Contenido principal -->
      <div class="main-content">
        <router-view/>
      </div>
    </div>
  </div>
</template>

<style>
/* Reset */
body {
  margin: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f4f7f6;
  color: #333;
}

/* Estructura principal */
.dashboard-container {
  display: flex;
  min-height: 100vh;
}

/* Sidebar */
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

.menu {
  display: flex;
  flex-direction: column;
}

.menu-item {
  padding: 15px 20px;
  cursor: pointer;
  border-left: 5px solid transparent;
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
  color: white;
  font-weight: 500;
}

.menu-item:hover {
  background-color: #34495e;
}

.menu-item.active {
  background-color: #1abc9c;
  border-left: 5px solid #2ecc71;
  font-weight: bold;
}

/* Contenido */
.main-content {
  flex-grow: 1;
  padding: 30px;
}
</style>
