<script setup>
import { defineProps, defineEmits } from 'vue'

defineProps(['contacts'])
const emits = defineEmits(['selected', 'delete'])

  function editSelected(contact) {
    if (contact) {
      emits('selected', contact)
    } else {
      console.log('Nie wybrano żadnego rekordu do edycji.');
    }
  }

  function deleteSelected(contact) {
    if (contact) {
      if (confirm('Czy na pewno chcesz usunąć ten zapis?')) {
        emits('delete', contact)
      }
    } else {
      console.log('Nie wybrano żadnego rekordu.');
    }
  }
</script>

<template>
  <table class="table table-striped">
    <tr>
      <th>id</th>
      <th>name</th>
      <th>surname</th>
      <th>email</th>
      <th>contents</th>
      <th>actions
        <button type="button" class="btn btn-warning" @click="addItem()">Dodaj</button>
      </th>
    </tr>

    <tr v-for="contact in contacts" v-bind:key="contact.id"
        :class="{ 'selected': selectedContact === contact }"
        @mouseover="highlightContact(contact)"
        @mouseleave="removeHighlight"
        @click="selectContact(contact)">
      <td>{{contact.id}}</td>
      <td>{{contact.name}}</td>
      <td>{{contact.surname}}</td>
      <td>{{contact.email}}</td>
      <td>{{contact.contents}}</td>
      <td>
          <button type="button" class="btn btn-success" @click="editSelected(contact)">Edycja</button>
          <button type="button" class="btn btn-danger" @click="deleteSelected(contact)">Usuń</button>
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  data() {
    return {
      records: [ /* Twoje dane */ ],
      selectedContact: null // Przechowuje wybrany rekord
    };
  },
  methods: {
    highlightContact(contact) {
      this.selectedContact = contact;
    },
    removeHighlight() {
      this.selectedContact = null;
    },
    selectContact(contact) {
      this.selectedContact = contact;
    },
    addItem() {
      // Implement add functionality
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

  tr:nth-child(even) { background-color: #f8f8f8; }
  tr:hover { background-color: #ddd; }

  th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
  }

  button {
    width: 100px;
    margin-bottom: 5px;
  }
</style>
