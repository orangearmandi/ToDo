import { createRouter, createWebHistory } from 'vue-router';
import Login from './components/Login.vue';
import NoteCreate from './components/NoteCreate.vue';
import NoteEdit from './components/NoteEdit.vue';
import NoteList from './components/NoteList.vue';
import Register from './components/Register.vue';
import store from './store'; // Importa el store

// Función para verificar la autenticación
// Función para verificar la autenticación


// Definición de rutas
// Definición de rutas
const routes = [
    {
      path: '/',
      name: 'Login',
      component: Login,
      beforeEnter: (to, from, next) => {
        if (store.state.user) {
          next('/notes'); // Redirigir a la lista de notas si el usuario ya está autenticado
        } else {
          next(); // De lo contrario, continuar a la página de login
        }
      },
    },
    {
      path: '/notes',
      name: 'NoteList',
      component: NoteList,

    },
    {
      path: '/create',
      name: 'NoteCreate',
      component: NoteCreate,

    },
    {
      path: '/edit/:id',
      name: 'NoteEdit',
      component: NoteEdit,

    },
    {
      path: '/register',
      name: 'Register',
      component: Register,
    }
  ];

  // Creación del enrutador
  const router = createRouter({
    history: createWebHistory(),
    routes,
  });

  export default router;
