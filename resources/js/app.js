import './bootstrap';
// Import the Vue instance
import { createApp } from 'vue';

// Import the Vuetify instance
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

// Import the HomeComponent
import HomeComponent from "./components/HomeComponent.vue";

// Create a new Vuetify instance
const vuetify = createVuetify({
    components,
    directives,
})

// Create a new Vue instance
const app = createApp({});

// Register the HomeComponent component
app.component("home-component", HomeComponent);

// Mount the app
app.use(vuetify).mount("#app");

