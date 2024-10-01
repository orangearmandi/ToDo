<template>
    <div class="login-container">
      <h2>Login</h2>
      <form @submit.prevent="login" class="login-form">
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          required
          class="input-field"
        />
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          required
          class="input-field"
        />
        <button type="submit" class="login-button">Login</button>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p> <!-- Mensaje de error -->
      </form>
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
          localStorage.setItem('token', response.data.token); // Guardar el token en el almacenamiento local
          console.log('Token almacenado:', response.data.token); // Verifica que se haya guardado correctamente
          this.$router.push('/'); // Redirigir a la lista de notas
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
  </style>
