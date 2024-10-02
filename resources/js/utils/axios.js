import axios from 'axios';
import store from '../store'; // Asegúrate de importar el store

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Cambia esto por la URL de tu API
});

// Interceptor para agregar el token de autorización a las solicitudes
api.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token'); // O de donde guardes el token
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    console.error('Error en la solicitud:', error); // Log de error
    return Promise.reject(error);
  }
);

// Interceptor para manejar respuestas de error
api.interceptors.response.use(
  response => response,
  error => {
    // Manejo de errores de respuesta
    if (error.response) {
      if (error.response.status === 401) {
        console.error('No autorizado, redirigiendo a login...');
        store.commit('clearToken'); // Limpia el token en el store
        window.location.href = '/'; // Redirige a la página de inicio de sesión
      } else if (error.response.status === 403) {
        console.error('Acceso prohibido:', error.response.data.message);
      } else {
        console.error('Error en la respuesta:', error.response.data.message);
      }
    } else {
      console.error('Error desconocido:', error.message);
    }
    return Promise.reject(error);
  }
);

export default api;
