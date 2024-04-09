<template>
  <ContactsData msg=""/>
<!--  <ContactsData msg="ContactForms Data"/>-->
</template>

<script>
import ContactsData from './components/ContactsData.vue'

export default {
  name: 'App',
  components: {
    ContactsData
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
