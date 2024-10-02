require('./bootstrap');
import { createApp } from 'vue'; // Importa createApp de vue

import SidebarMenu from './components/menu.vue';
import router from './router'; // Importa el enrutador
import store from './store'; // Importa el store
const app = createApp({}); // Crea la aplicación

// Si tienes componentes globales que quieres registrar, lo puedes hacer aquí
// Ejemplo: app.component('example-component', require('./components/ExampleComponent.vue').default);

// Usa el enrutador y el store en la aplicación
app.component('SidebarMenu', SidebarMenu);
app.use(router);
app.use(store);

// Monta la aplicación en el elemento con el ID 'app'
app.mount('#app');
