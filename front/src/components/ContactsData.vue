<script setup>
  import ContactsForm from './ContactsForm.vue'
  import ContactsList from './ContactsList.vue'
  import { store } from './store.js'  
  import { ref } from 'vue'

  const contacts = ref([])
  const selectedContact = ref(null)

  function onSaved(contact) {
    store.addContact(contact)
  }
  function onSelected(selected) {
    // store.addContact(contact)
    selectedContact.value = selected;
  }
</script>

<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
  </div>
  <ContactsForm :contact="selectedContact ? selectedContact : null" @saved="onSaved" />
  <ContactsList @selected="onSelected"/>
</template>

<script>
  export default {
    name: 'ContactsData',
    components: {
      ContactsForm,
      ContactsList,
    },
    props: {
      msg: String
    }
}
</script>
