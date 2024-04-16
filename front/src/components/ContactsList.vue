<script setup>
  import ContactsGrid from './ContactsGrid.vue'
  import Pagination from "@/components/Pagination.vue";
  import { ref, onMounted, defineEmits, inject } from 'vue'
  import { store } from './store.js'

  const emits = defineEmits(['selected', 'delete'])

  const currentPage = ref(1)
  const perPage = ref(5)

  onMounted(async () => {
    store.contacts = await fetchContacts();
    console.log(store.contacts)
  })
  function onSelected(contact) {
    emits('selected', contact);
  }

  function onDelete(contact) {
    emits('delete', contact);
  }

  function onPageChange(page) {
    console.log(page)
    currentPage.value = page;
  }

  const fetchContacts = async () => {
    try {
      console.log(currentPage, perPage)
      const fethContsctsUrl = 'http://localhost:8000/contactforms/'+currentPage.value+'/'+perPage.value
      const response = await fetch(fethContsctsUrl);
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
    <Pagination :current-page=currentPage :per-page=perPage total-pages=4 @pagechanged="onPageChange"/>
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