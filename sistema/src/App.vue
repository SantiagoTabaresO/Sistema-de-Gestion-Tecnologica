<template>
  <div class="container">
  <nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav">
      <router-link to="/" class="nav-link">Home</router-link> 
      <router-link to="/ResponsablesView" class="nav-link">Responsables</router-link>      
      <router-link to="/about" class="nav-link">About</router-link>
    </div>
    </nav>
  </div>
  <br>
  <router-view/>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
  /* AÑADE ESTA LÍNEA para crear un espacio a la derecha de cada enlace */
  margin-right: 15px; 
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>

