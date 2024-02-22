import './bootstrap';
import { createApp } from 'vue';
import vuetify from './vuetify'; // Ensure this path is correct
import router from './router'; // Ensure this path is correct
import Login from './components/Login.vue'; // Main App component
import LiveQueue from './components/LiveQueue.vue'; // Main App component
import BaseLayout from './components/BaseLayout.vue'; // Main App component

const app = createApp({}); // Pass App component to createApp

app.use(router);
app.use(vuetify);

app.component('login-page', Login);
app.component('live-queue', LiveQueue);
app.component('base-layout', BaseLayout);

app.mount('#app');