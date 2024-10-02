<template>
    <div>
      <button @click="toggleMenu" class="btn-toggle-menu">☰</button>

      <div v-if="menuOpen" class="sidebar">
        <button class="btn-close" @click="toggleMenu">✖</button>
        <br />
        <br />
        <br />
        <ul class="menu-items">
          <li @click="logout">Cerrar Sesión</li>
        </ul>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        menuOpen: false, // Estado para controlar la apertura del menú
      };
    },
    methods: {
      toggleMenu() {
        this.menuOpen = !this.menuOpen; // Cambia el estado del menú
      },
      async logout() {
        const token = localStorage.getItem('token');
        try {
          await axios.post('http://localhost:8000/api/logout', {}, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          });
          localStorage.removeItem('token'); // Limpiar el token
          this.$router.push('/'); // Redirigir al inicio de sesión
        } catch (error) {
          console.error('Error al cerrar sesión:', error);
        } finally {
          this.menuOpen = false; // Cierra el menú al cerrar sesión
        }
      },
    },
  };
  </script>

  <style scoped>
  .sidebar {
    position: fixed; /* Mantener el menú en una posición fija */
    top: 0; /* Ajusta a la parte superior de la ventana */
    right: 0; /* Mantener a la derecha */
    width: 250px; /* Ancho del menú */
    height: 100%; /* Altura completa */
    background-color: #f8f9fa; /* Color de fondo del menú */
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.2); /* Sombra del menú */
    z-index: 9999; /* Un z-index alto para asegurar que esté encima de otros elementos */
    padding: 20px; /* Espaciado interno */
    transition: transform 0.3s ease; /* Transición suave al abrir/cerrar */
  }

  .btn-toggle-menu {
    position: fixed; /* Mantener el botón en la parte superior derecha */
    top: 20px; /* Espaciado desde la parte superior */
    right: 20px; /* Espaciado desde la derecha */
    background-color: #28a745; /* Color de fondo verde */
    color: white; /* Color del ícono */
    border: none; /* Sin borde */
    border-radius: 50%; /* Bordes redondeados */
    padding: 12px; /* Espaciado interno */
    font-size: 24px; /* Tamaño del ícono */
    cursor: pointer; /* Cambiar el cursor al pasar */
    z-index: 10000; /* Asegurarse de que el botón esté por encima del menú */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra para profundidad */
    transition: background-color 0.3s, transform 0.2s; /* Transiciones suaves */
  }

  .btn-toggle-menu:hover {
    background-color: #218838; /* Color más oscuro al pasar el mouse */
    transform: scale(1.05); /* Efecto de aumento al pasar el mouse */
  }

  .menu-items {
    list-style-type: none; /* Sin viñetas */
    padding: 0; /* Sin espaciado */
  }

  .menu-items li {
    margin-bottom: 15px; /* Espaciado entre elementos */
  }

  .menu-items li:hover {
    color: #007bff; /* Color al pasar el mouse */
    cursor: pointer; /* Cambia el cursor al pasar */
  }

  .btn-close {
    background: none; /* Sin fondo */
    border: none; /* Sin borde */
    font-size: 24px; /* Tamaño del ícono */
    cursor: pointer; /* Cambiar el cursor al pasar */
    color: #dc3545; /* Color rojo para el botón de cerrar */
  }

  .btn-close:hover {
    transform: scale(1.1); /* Efecto de aumento al pasar el mouse */
  }
  </style>
