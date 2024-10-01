<template>
    <div>
      <h1>Editar Nota</h1>
      <form @submit.prevent="updateNote">
        <input v-model="note.title" placeholder="Título" required />
        <textarea v-model="note.description" placeholder="Descripción" required></textarea>
        <input v-model="note.user" placeholder="Usuario" required />
        <input v-model="note.tags" placeholder="Etiquetas (separadas por comas)" required />
        <input v-model="note.due_date" type="date" required />
        <input v-model="note.image_path" placeholder="Ruta de imagen" />
        <button type="submit">Actualizar Nota</button>
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
