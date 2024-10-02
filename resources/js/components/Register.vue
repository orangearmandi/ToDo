<template>
    <div class="register-container">
      <h2>Registro de ToDo</h2>
      <img
        src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Microsoft_To-Do_icon.svg"
        alt="Logo"
        class="logo"
      />
      <form @submit.prevent="register" class="register-form">
        <input v-model="name" placeholder="Name" required class="input-field" />
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
      <p class="login-prompt">
        ¿Ya tienes una cuenta?
        <button @click="goToLogin" class="login-button">Volver a Login</button>
      </p>
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
          this.$router.push('/'); // Redirigir a Login después del registro
        } catch (error) {
          // Manejo de errores
          this.errorMessage =
            error.response.data.message ||
            'Error al registrarse. Inténtalo de nuevo.'; // Mostrar mensaje de error
          console.error('Error en el registro:', error.response.data); // Log detallado para depuración
        }
      },
      goToLogin() {
        this.$router.push('/'); // Redirigir a la página de inicio de sesión
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
    width: 90%; /* Para que el contenedor sea más ancho en pantallas pequeñas */
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
    width: 100%; /* Asegúrate de que el campo de entrada ocupe todo el ancho disponible */
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

  .login-prompt {
    text-align: center;
    margin-top: 20px;
  }

  .login-button {
    background: none;
    border: none;
    color: #007bff;
    cursor: pointer;
    font-size: 16px;
  }

  .login-button:hover {
    text-decoration: underline;
  }

  /* Media queries para mayor responsividad */
  @media (max-width: 600px) {
    .register-container {
      padding: 15px; /* Reduce el padding en pantallas pequeñas */
    }

    h2 {
      font-size: 1.5rem; /* Tamaño de fuente más pequeño para el título */
    }

    .input-field {
      font-size: 14px; /* Tamaño de fuente más pequeño para los campos de entrada */
    }

    .register-button,
    .login-button {
      font-size: 14px; /* Tamaño de fuente más pequeño para los botones */
    }
  }
  </style>
