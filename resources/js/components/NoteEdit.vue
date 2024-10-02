<template>
    <div class="edit-note-container">
      <h1 class="title">Editar Nota</h1>
      <form @submit.prevent="updateNote" class="edit-note-form">
        <input v-model="note.title" placeholder="Título" required class="input-field" />
        <textarea v-model="note.description" placeholder="Descripción" required class="textarea-field"></textarea>
        <!-- Eliminar el campo de usuario del formulario -->
        <div class="user-field">Usuario ID: {{ note.user }}</div> <!-- Solo mostrar el ID del usuario -->
        <input v-model="note.tags" placeholder="Etiquetas (separadas por comas)" required class="input-field" />
        <input v-model="note.due_date" type="date" required class="input-field" />
        <button type="submit" class="update-button">Actualizar Nota</button>
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        note: {
          title: '',
          description: '',
          user: '', // Mantener el ID del usuario pero no permitir que sea editable
          tags: '',
          due_date: '',
        }
      };
    },
    created() {
      this.fetchNote();
    },
    methods: {
      async fetchNote() {
        try {
          const response = await axios.get(`http://localhost:8000/api/notes/edit/${this.$route.params.id}`);
          this.note = response.data;
        } catch (error) {
          console.error("Error fetching note:", error);
          alert("Error fetching note: " + error.message);
        }
      },
      async updateNote() {
        if (!this.note.title || !this.note.description || !this.note.tags || !this.note.due_date) {
          alert("Por favor, complete todos los campos.");
          return;
        }

        // Recuperar el token del almacenamiento local
        const token = localStorage.getItem('token');
        if (!token) {
          alert("No estás autenticado. Por favor, inicia sesión.");
          this.$router.push('/notes'); // Redirigir si no hay autenticación
          return;
        }

        try {
          // Realizar la solicitud PUT para actualizar la nota
          await axios.put(`http://localhost:8000/api/notes/edit/${this.$route.params.id}`, {
            title: this.note.title,
            description: this.note.description,
            user: this.note.user, // Enviar el ID del usuario sin modificar
            tags: this.note.tags,
            due_date: this.note.due_date
          }, {
            headers: {
              Authorization: `Bearer ${token}`, // Agregar el token de autorización
            },
          });
          this.$router.push('/'); // Redirigir a la página de inicio de sesión
        } catch (error) {
          console.error("Error updating note:", error);
          alert("Error updating note: " + error.message);
        }
      }
    }
  };
  </script>

  <style scoped>
  .edit-note-container {
    max-width: 500px;
    margin: 50px auto;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
  }
  .title {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  .edit-note-form {
    display: flex;
    flex-direction: column;
  }
  .input-field,
  .textarea-field {
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
  }
  .textarea-field {
    resize: vertical;
  }
  .input-field:focus,
  .textarea-field:focus {
    border-color: #007bff;
    outline: none;
  }
  .update-button {
    padding: 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
  }
  .update-button:hover {
    background-color: #0056b3;
  }
  .user-field {
    margin-bottom: 15px;
    font-size: 16px;
    color: #555;
  }
  </style>
