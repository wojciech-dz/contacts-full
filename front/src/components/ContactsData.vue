<script setup>
  import ContactsForm from './ContactsForm.vue'
  import ContactsList from './ContactsList.vue'
  import { store } from './store.js'  
  import { ref } from 'vue'

  const contacts = ref([])

  function onSaved(contact) {
    store.addContact(contact)
  }
</script>

<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
  </div>
  <ContactsForm  @saved="onSaved" />
  <ContactsList />
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
