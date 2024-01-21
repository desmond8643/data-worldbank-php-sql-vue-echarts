<template>
  <div id="app">
    <ApiComponent />
  </div>
</template>

<script>
import ApiComponent from './components/ApiComponent.vue';

export default {
  name: 'App',
  components: {
    ApiComponent
  }
};
</script>