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
  function onSelected(selectedContact) {
    // store.addContact(contact)
    console.log(selectedContact)
  }
</script>

<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
  </div>
  <ContactsForm  :contact="selectedContact" @saved="onSaved" />
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
