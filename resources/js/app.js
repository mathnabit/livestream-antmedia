import './bootstrap';
// Import the Vue instance
import { createApp } from 'vue';
// Import the HomeComponent
import HomeComponent from "./components/HomeComponent.vue";
// Mount the app to the #app element
const app = createApp({});
app.component("home-component", HomeComponent);
app.mount("#app");
