import './bootstrap';
// Import Vue
import { createApp } from 'vue';

// Import Vue Router
import router from './router';

// Import Vuetify and its components
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import 'vuetify/styles'
// Import Material Design Icons
import '@mdi/font/css/materialdesignicons.css'; 


// Import views and components
import NavbarComponent from "./components/NavbarComponent.vue";
import DashboardVue from "./views/DashboardVue.vue";
import StreamVue from "./views/StreamVue.vue";
import StreamListVue from "./views/StreamListVue.vue";


// Create a new Vuetify instance
const vuetify = createVuetify({
    components,
    directives,
    // Use Material Design Icons as the default icon set
    icons: {
        defaultSet: 'mdi', 
    },
})

// Create a new Vue instance
const app = createApp({});

// Register views components
app.component("navbar-component", NavbarComponent);
app.component("dashboard-view", DashboardVue);
app.component("stream-view", StreamVue);
app.component("streamlist-view", StreamListVue);

// Mount the app
app
.use(router)
.use(vuetify)
.mount("#app");

