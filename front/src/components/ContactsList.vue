<script setup>
  import ContactsGrid from '@/components/ContactsGrid.vue'
  import Pagination from "@/components/Pagination.vue";
  import { ref, onMounted, defineEmits, inject } from 'vue'
  import { store } from '@/components/store.js'

  const emits = defineEmits(['selected', 'delete'])

  const currentPage = ref(1)
  const perPage = ref(5)
  const totalPages = ref(2)

  onMounted(async () => {
    let result = await fetchContacts()
    console.log(result)
    store.contacts = result.contacts
    totalPages.value = result.pages
    // console.log(currentPage.value, perPage.value)

  })
  function onSelected(contact) {
    emits('selected', contact);
  }

  function onDelete(contact) {
    emits('delete', contact);
  }

  async function onPageChange(page) {
    console.log(page)
    currentPage.value = page;
    let result = await fetchContacts()
    console.log(result)
    store.contacts = result.contacts
    totalPages.value = result.pages
  }

  const fetchContacts = async () => {
    try {
      // console.log(currentPage.value, perPage.value)
      const fethContsctsUrl = 'http://localhost:8000/contactforms/'+((currentPage.value-1)*perPage.value)+'/'+perPage.value
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
    <Pagination :current-page=currentPage :per-page=perPage :total-pages=totalPages @pagechanged="onPageChange"/>
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