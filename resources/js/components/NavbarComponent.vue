<template>
    <!-- Navigation Drawer -->
    <v-navigation-drawer
        v-model="drawer"
        app
        dark
        class="indigo-darken-1"
        floating
        permanent
        expand-on-hover
    >
    <!-- Navigation Links -->
    <v-list>
        <v-list-item
        prepend-avatar="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp"
        subtitle="contact@livestream.co"
        title="Jhon Doe"
        class="text-white"
        ></v-list-item>
    </v-list>

    <v-list
        density="compact"
        nav
    >
        <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard" to="/" class="text-white"></v-list-item>
        <v-list-item prepend-icon="mdi-video-plus" title="Create Stream" value="createstream" to="/stream" class="text-white"></v-list-item>
        <v-list-item prepend-icon="mdi-playlist-play" title="Stream List" value="streamlist" to="/stream-list" class="text-white"></v-list-item>
    </v-list>
    <template v-slot:append>
        <div class="pa-2">
        <v-btn block>
            Logout
        </v-btn>
        </div>
    </template>
    </v-navigation-drawer>

    <!-- App Bar -->
    <v-app-bar app clipped-right flat  class="grey-lighten-2">
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
        <v-toolbar-title class="">
            <span class="font-weight-bold">Antmedia </span>
            <span class="font-weight-light">Live Stream</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
    </v-app-bar>

</template>
  
<script>
export default {
    data() {
        return {
            drawer: true,
        };
    },
    methods: {

    },
};
</script>

<style scoped>
/* Custom Styles */
.indigo-darken-1 {
    background-color: #3949AB !important;
}
.grey-lighten-2 {
    background-color: #e8e7e7 !important;
}

.v-btn--plain {
    text-transform: none;
}
</style>