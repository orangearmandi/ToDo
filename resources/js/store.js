import { createStore } from 'vuex'; // Importa Vuex

// Crea la tienda usando createStore
export default createStore({
  state: {
    token: localStorage.getItem('token') || '', // Cargar el token del localStorage
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
      localStorage.setItem('token', token); // Guardar en localStorage
    },
    clearToken(state) {
      state.token = '';
      localStorage.removeItem('token'); // Eliminar de localStorage
    },
  },
  actions: {
    setToken({ commit }, token) {
      commit('setToken', token); // Llamar a la mutación para establecer el token
    },
    logout({ commit }) {
      commit('clearToken'); // Llamar a la mutación para limpiar el token
    },
  },
});
