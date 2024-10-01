// src/utils/axios.js
import axios from 'axios';

const api = axios.create({
    baseURL: 'http://127.0.0.1:8000/api', // Cambia esto por la URL de tu API
});

// Interceptor para agregar el token de autorización a las solicitudes
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // O de donde guardes el token
    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
}, error => {
    // Manejo de errores de la solicitud
    return Promise.reject(error);
});

// Interceptor para manejar respuestas de error
api.interceptors.response.use(response => {
    return response;
}, error => {
    // Manejo de errores de respuesta
    if (error.response && error.response.status === 401) {
        // Aquí puedes redirigir al usuario a la página de inicio de sesión o mostrar un mensaje de error
        console.error('No autorizado, redirigiendo a login...');
    }
    return Promise.reject(error);
});

export default api;
