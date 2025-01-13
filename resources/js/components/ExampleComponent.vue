<!-- resources/js/components/ExampleComponent.vue -->
<template>
  <div>
    <h1>{{ message }}</h1>
    <button @click="changeMessage">Click Me</button>
  </div>
</template>

<script>
export default {
  name: 'ExampleComponent',
  data() {
    return {
      message: 'Hello from Vue!',
    };
  },
  methods: {
    changeMessage() {
      this.message = 'You clicked the button!';
    },
  },
};
</script>

<style scoped>
h1 {    
  color: blue;
}
</style>
