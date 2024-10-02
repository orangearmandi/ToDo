<template>
    <div class="login-container">
      <h2>Login</h2>
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Microsoft_To-Do_icon.svg" alt="Logo" class="logo" />
      <form @submit.prevent="login" class="login-form">
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="input-field"
          aria-label="Email"
        />
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
          class="input-field"
          aria-label="Password"
        />
        <button type="submit" class="login-button">Login</button>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p> <!-- Mensaje de error -->
      </form>
      <div class="register-link">
        <p>¿No tienes una cuenta? <router-link to="/register" class="register-button">Regístrate aquí</router-link></p>
      </div>
    </div>
  </template>

  <script>
  import api from '../utils/axios';

  export default {
    data() {
      return {
        email: '',
        password: '',
        errorMessage: '' // Para mostrar mensajes de error
      };
    },
    methods: {
      async login() {
        try {
          const response = await api.post('/login', {
            email: this.email,
            password: this.password
          });

          // Guarda el token en el localStorage
          localStorage.setItem('token', response.data.access_token);
          console.log('Token almacenado:', response.data.access_token); // Verifica que se haya guardado correctamente

          // Redirigir a la lista de notas
          this.$router.push('/notes'); // Cambia esto para que redirija a '/notes'
        } catch (error) {
          // Manejo de errores
          console.error('Error en el inicio de sesión:', error.response.data); // Log detallado
          this.errorMessage =
            error.response.data.message ||
            'Error de inicio de sesión. Inténtalo de nuevo.'; // Mostrar mensaje de error
        }
      }
    }
  };
  </script>

  <style scoped>
  /* Estilos opcionales */
  .login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
  }

  .logo {
    display: block;
    margin: 0 auto 20px; /* Centrar logo y agregar espaciado inferior */
    width: 60px; /* Ajusta el tamaño del logo según sea necesario */
  }

  h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }

  .login-form {
    display: flex;
    flex-direction: column;
  }

  .input-field {
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
  }

  .input-field:focus {
    border-color: #007bff;
    outline: none;
  }

  .login-button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  .login-button:hover {
    background-color: #0056b3;
  }

  .error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
  }

  .register-link {
    text-align: center;
    margin-top: 15px; /* Espaciado superior */
  }

  .register-button {
    color: #007bff;
    text-decoration: none; /* Sin subrayado */
  }

  .register-button:hover {
    text-decoration: underline; /* Subrayado al pasar el mouse */
  }
  </style>
