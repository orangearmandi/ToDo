<template>
    <div class="register-container">
      <h2>Register</h2>
      <form @submit.prevent="register" class="register-form">
        <input
          v-model="name"
          placeholder="Name"
          required
          class="input-field"
        />
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
        <input
          v-model="password_confirmation"
          type="password"
          placeholder="Confirm Password"
          required
          class="input-field"
        />
        <button type="submit" class="register-button">Register</button>
        <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p> <!-- Mensaje de error -->
      </form>
    </div>
  </template>

  <script>
  import api from '../utils/axios';

  export default {
    data() {
      return {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        errorMessage: '' // Para mostrar mensajes de error
      };
    },
    methods: {
      async register() {
        try {
          await api.post('/register', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          });
          this.$router.push('/login'); // Redirigir a Login después del registro
        } catch (error) {
          // Manejo de errores
          this.errorMessage =
            error.response.data.message ||
            'Error al registrarse. Inténtalo de nuevo.'; // Mostrar mensaje de error
          console.error('Error en el registro:', error.response.data); // Log detallado para depuración
        }
      }
    }
  };
  </script>

  <style scoped>
  .register-container {
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

  .register-form {
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

  .register-button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }

  .register-button:hover {
    background-color: #0056b3;
  }

  .error-message {
    color: red;
    text-align: center;
    margin-top: 10px;
  }
  </style>
