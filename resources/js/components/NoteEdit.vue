<template>
    <div class="edit-note-container">
      <h1 class="title">Editar Nota</h1>
      <form @submit.prevent="updateNote" class="edit-note-form">
        <input v-model="note.title" placeholder="Título" required class="input-field" />
        <textarea v-model="note.description" placeholder="Descripción" required class="textarea-field"></textarea>
        <input v-model="note.user" placeholder="Usuario" required class="input-field" />
        <input v-model="note.tags" placeholder="Etiquetas (separadas por comas)" required class="input-field" />
        <input v-model="note.due_date" type="date" required class="input-field" />
        <input v-model="note.image_path" placeholder="Ruta de imagen" class="input-field" />
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
          user: '',
          tags: '',
          due_date: '',
          image_path: ''
        }
      };
    },
    created() {
      this.fetchNote();
    },
    methods: {
      async fetchNote() {
        const response = await axios.get(`http://localhost:8000/api/notes/${this.$route.params.id}`);
        this.note = response.data;
      },
      async updateNote() {
        await axios.put(`http://localhost:8000/api/notes/${this.$route.params.id}`, this.note);
        this.$router.push('/');
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
  </style>
