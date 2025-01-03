<template>
    <v-app>
        <!-- App Bar -->
        <v-app-bar :elevation="2">
            <template v-slot:prepend>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            </template>

            <v-app-bar-title>Application Bar</v-app-bar-title>
        </v-app-bar>
        <!-- Main Content -->
        <v-main>
        <div class="home">
            <h1>Welcome to Home Component</h1>
            <v-btn color="primary">Button</v-btn>
        </div>
        </v-main>
    </v-app>
       
</template>

<script>
export default {
    name: 'HomeComponent',
    data() {
        return {
            message: 'Hello, Vue!'
        };
    },
    methods: {
        greet() {
            alert(this.message);
        }
    }
};
</script>

<style scoped>
.home {
    text-align: center;
}
</style>