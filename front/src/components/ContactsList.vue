<script setup>
  import ContactsGrid from './ContactsGrid.vue'
  import { ref, onMounted, defineEmits, inject } from 'vue'
  import { store } from './store.js'

  const emits = defineEmits(['selected', 'delete'])

  onMounted(async () => {
    store.contacts = await fetchContacts();
  })
  function onSelected(contact) {
    emits('selected', contact);
  }

  function onDelete(contact) {
    emits('delete', contact);
  }

  const fetchContacts = async () => {
    try {
        const response = await fetch('http://localhost:8000/contactforms');
        if (!response.ok) {
            throw new Error('Failed to fetch contacts');
        }
        return response.json()
    } catch (error) {
        console.error(error);
    }
  }

</script>

<template>
  <div class="table-container">
    <ContactsGrid :contacts="store.contacts" @selected="onSelected" @delete="onDelete"/>
  </div>
</template>

<script>
	export default {
		name: 'ContactsList',
	}
</script>

<style scoped>
  .table-container {
    margin-left: 3rem;
  }
</style>