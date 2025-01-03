<template>
    <div class="home">
        <h1>Welcome to Home Component</h1>
    </div>
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