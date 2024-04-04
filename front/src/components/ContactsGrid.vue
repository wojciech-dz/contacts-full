<script setup>
// import { store } from './store.js'
import { defineProps } from 'vue'

defineProps(['contacts'])

</script>

<template>
  <table>
    <tr>
      <th>id</th>
      <th>name</th>
      <th>surname</th>
      <th>email</th>
      <th>contents</th>
      <th>actions</th>
    </tr>

    <tr v-for="contact in contacts" v-bind:key="contact.id">
      <td>{{contact.id}}</td>
      <td>{{contact.name}}</td>
      <td>{{contact.surname}}</td>
      <td>{{contact.email}}</td>
      <td>{{contact.contents}}</td>
      <td>
        <button @click="editItem(contact)">Edycja</button>
        <button @click="deleteItem(contact.id)">Usuń</button>
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  methods: {
    editItem(item) {
      // Implement edit functionality
    },
    deleteItem(itemId) {
      // Implement delete functionality
    },
  },
};
</script>

<style scoped>
  table {
    width: 80%;
    min-width: 250px;
    text-align: left;
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    margin: 10px;
  }

  td, th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  tr:nth-child(even) { background-color: #f2f2f2; }
  tr:hover { background-color: #ddd; }

  th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }
</style>