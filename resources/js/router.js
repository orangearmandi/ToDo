import Vue from 'vue';
import Router from 'vue-router';
import Login from './components/Login.vue';
import NoteCreate from './components/NoteCreate.vue';
import NoteEdit from './components/NoteEdit.vue';
import NoteList from './components/NoteList.vue';
import Register from './components/Register.vue';
import api from './utils/axios'; // Importa la instancia de Axios

Vue.use(Router);

const isAuthenticated = () => {
  const token = localStorage.getItem('token');
  return !!token; // Devuelve true si el token existe
};

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'NoteList',
      component: NoteList,
      beforeEnter: (to, from, next) => {
        if (isAuthenticated()) {
          next();
        } else {
          next('/login');
        }
      }
    },
    {
      path: '/create',
      name: 'NoteCreate',
      component: NoteCreate,
      beforeEnter: (to, from, next) => {
        if (isAuthenticated()) {
          next();
        } else {
          next('/login');
        }
      }
    },
    {
      path: '/edit/:id',
      name: 'NoteEdit',
      component: NoteEdit,
      beforeEnter: (to, from, next) => {
        if (isAuthenticated()) {
          next();
        } else {
          next('/login');
        }
      }
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
  ]
});

// Manejo de errores en la respuesta de Axios para redirigir
api.interceptors.response.use(
  response => {
    return response;
  },
  error => {
    // Manejo de errores de respuesta
    if (error.response && error.response.status === 401) {
      console.error('No autorizado, redirigiendo a login...');
      router.push('/login'); // Redirige a la página de login
    }
    return Promise.reject(error);
  }
);

export default router;
