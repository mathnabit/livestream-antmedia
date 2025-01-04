// Import Vue Router 
import { createRouter, createWebHistory } from 'vue-router';

// Import your Vue components
import DashboardVue from './views/DashboardVue.vue';
import StreamVue from './views/StreamVue.vue';
import StreamListVue from './views/StreamListVue.vue';

// Define your routes
const routes = [
  { path: '/', component: DashboardVue, name: 'dashboard' },
  { path: '/stream', component: StreamVue, name: 'stream' },
  { path: '/stream-list', component: StreamListVue, name: 'stream-list' },
];

// Create the router instance with HTML5 history mode
const router = createRouter({
    history: createWebHistory(), 
    routes, 
});

export default router;