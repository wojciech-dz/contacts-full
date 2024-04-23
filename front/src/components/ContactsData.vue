<script setup>
  import ContactsForm from '@/components/ContactsForm.vue'
  import ContactsList from '@/components/ContactsList.vue'
  import { store } from '@/components/store.js'
  import { ref } from 'vue'
  import ContactsGrid from "@/components/ContactsGrid.vue";
  import axios from "axios";

  const contacts = ref([])
  const selectedContact = ref(null)

  function onSaved(contact) {
    store.addContact(contact)
  }

  function onCleared() {
    // store.clearContact()
  }
  function onSelected(selected) {
    selectedContact.value = selected;
  }

  function onDelete(selected) {
    selectedContact.value = selected;
    deleteContact(selected);
  }

  async function deleteContact(contact) {
    try {
      const contactId = contact.id;
      const url = 'http://localhost:8000/contactform' + '/' + contactId;
      const response = await axios.delete(url);
      store.deleteContact(contact)
    } catch (error){
      console.log(error)
    }
  }
</script>

<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
  </div>
  <ContactsForm :contact="selectedContact ? selectedContact : null" @saved="onSaved" @cleared="onCleared"/>
  <ContactsList @selected="onSelected" @delete="onDelete"/>
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
