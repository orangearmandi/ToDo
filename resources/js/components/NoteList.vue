<template>
    <div class="container">
      <h1>Notas</h1>
      <div class="note-list">
        <div class="note-item" v-for="note in notes" :key="note.id">
          <h2>{{ note.title }}</h2>

          <!-- Descripción truncada con "Ver más/Ver menos" -->
          <p class="note-description">
            {{ isExpanded[note.id] ? note.description : truncateText(note.description) }}
          </p>
          <button v-if="note.description.length > 20" class="btn-toggle" @click="toggleExpand(note.id)">
            {{ isExpanded[note.id] ? 'Ver menos' : 'Ver más' }}
          </button>

          <div class="note-meta">
            <p><strong>Usuario:</strong> {{ note.user }}</p>
            <!-- Etiquetas separadas con estilo de chip -->
            <div class="tags">
              <span class="tag" v-for="tag in note.tags.split(',')" :key="tag">{{ tag.trim() }}</span>
            </div>
            <p><strong>Fecha de Vencimiento:</strong> {{ note.due_date }}</p>
          </div>

          <img :src="`/storage/${note.image_path}`" alt="Imagen de nota" v-if="note.image_path" class="note-image" />

          <div class="note-actions">
            <router-link :to="{ name: 'NoteEdit', params: { id: note.id } }" class="btn-edit">Editar</router-link>
            <button class="btn-delete" @click="deleteNote(note.id)">Eliminar</button>
          </div>
        </div>
      </div>

      <!-- Botón flotante para crear una nueva nota -->
      <router-link to="/create" class="btn-create-float">+</router-link>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        notes: [],
        isExpanded: {}, // Para controlar qué notas están expandidas
      };
    },
    created() {
      this.fetchNotes();
    },
    methods: {
      async fetchNotes() {
        try {
          const response = await axios.get('http://localhost:8000/api/notes');
          this.notes = response.data;
        } catch (error) {
          console.error('Error fetching notes:', error);
        }
      },
      async deleteNote(noteId) {
        if (confirm('¿Estás seguro de que deseas eliminar esta nota?')) {
          try {
            await axios.delete(`http://localhost:8000/api/notes/${noteId}`);
            this.fetchNotes(); // Actualiza la lista de notas
          } catch (error) {
            console.error('Error deleting note:', error);
          }
        }
      },
      // Función para truncar el texto a 40 caracteres
      truncateText(text) {
        return text.length > 40 ? text.slice(0, 40) + '...' : text;
      },
      // Alterna entre mostrar texto truncado y completo
      toggleExpand(noteId) {
        this.$set(this.isExpanded, noteId, !this.isExpanded[noteId]);
      },
    },
  };
  </script>

  <style scoped>
  .container {
    max-width: 1200px; /* Ancho más amplio */
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .note-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Ancho más grande para cada tarjeta */
    gap: 20px;
  }

  .note-item {
    background-color: #f9f9f9;
    padding: 15px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }

  .note-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  }

  h2 {
    font-size: 1.5rem; /* Aumentado */
    color: #333;
    margin-bottom: 10px;
  }

  .note-description {
    font-size: 1rem;
    color: #555;
    margin-bottom: 10px;
    line-height: 1.5;
  }

  .note-meta p {
    font-size: 0.95rem; /* Aumentado */
    color: #777;
    margin: 5px 0;
  }

  .tags {
    margin: 10px 0;
  }

  .tag {
    display: inline-block;
    background-color: #e0f7fa;
    color: #00796b;
    padding: 6px 12px; /* Aumentado */
    margin-right: 5px;
    border-radius: 20px; /* Aumentado para un mejor aspecto */
    font-size: 0.9rem; /* Aumentado */
    transition: background-color 0.3s;
  }

  .tag:hover {
    background-color: #b2ebf2; /* Cambia de color al pasar el mouse */
  }

  .note-image {
    width: 100%;
    height: auto;
    margin-top: 10px;
    border-radius: 10px;
  }

  .note-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
  }

  .btn-edit,
  .btn-delete,
  .btn-toggle {
    padding: 10px 15px; /* Aumentado */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 0.9rem; /* Aumentado */
  }

  .btn-edit {
    background-color: #007bff;
    color: #fff;
  }

  .btn-edit:hover {
    background-color: #0069d9;
  }

  .btn-delete {
    background-color: #dc3545;
    color: #fff;
  }

  .btn-delete:hover {
    background-color: #c82333;
  }

  .btn-toggle {
    background-color: #6c757d;
    color: white;
    margin-top: 5px;
  }

  .btn-toggle:hover {
    background-color: #5a6268;
  }

  /* Botón flotante */
  .btn-create-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #28a745;
    color: #fff;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 2rem;
    text-decoration: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .btn-create-float:hover {
    background-color: #218838;
    transform: scale(1.1);
  }
  </style>
