<template>
    <div class="note-card">
      <h2>{{ title }}</h2>
      <p>{{ description }}</p>
      <p><strong>Creación:</strong> {{ creationDate }}</p>
      <p><strong>Usuario:</strong> {{ user }}</p>

      <ul v-if="tags.length">
        <li v-for="tag in tags" :key="tag">{{ tag }}</li>
      </ul>

      <p v-if="expirationDate"><strong>Vence:</strong> {{ expirationDate }}</p>

      <img v-if="image" :src="image" alt="Imagen de la Nota" />
    </div>
  </template>

  <script>
  export default {
    props: {
      title: String,
      description: String,
      creationDate: String,
      user: String,
      tags: Array,
      expirationDate: String,
      image: String
    }
  }
  </script>

  <style scoped>
  .note-card {
    background-color: #f70404;
    border: 1px solid #ca0606;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
  }

  .note-card img {
    max-width: 100%;
    height: auto;
    margin-top: 1rem;
    border-radius: 8px;
  }
  </style>
