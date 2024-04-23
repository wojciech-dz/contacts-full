<script setup>
  import { ref, onMounted, defineEmits } from 'vue'
  import ContactsGrid from '@/components/ContactsGrid.vue'
  import { store } from '@/components/store.js'
  import Pagination from "@/components/Pagination.vue";

  const emits = defineEmits(['selected', 'delete'])

  const currentPage = ref(1)
  const perPage = ref(5)
  const totalPages = ref(12)
  const maxVisibleButtons = ref(5)
  const contacts = ref([])
  const rerenderPagination = ref(false)

  onMounted(async () => {
    let result = await fetchContacts()
    store.contacts = result.contacts
    totalPages.value = result.pages
    maxVisibleButtons.value = Math.min(maxVisibleButtons.value, result.pages)
    rerenderPagination.value = true
  })
  function onSelected(contact) {
    emits('selected', contact);
  }

  function onDelete(contact) {
    emits('delete', contact);
  }

  async function onPageChange(page) {
    currentPage.value = page;
    let result = await fetchContacts()
    store.contacts = result.contacts
    maxVisibleButtons.value = Math.min(maxVisibleButtons.value, result.pages)
    totalPages.value = result.pages
  }

  const fetchContacts = async () => {
    try {
      const fetchContactsUrl = 'http://localhost:8000/contactforms/'+((currentPage.value-1)*perPage.value)+'/'+perPage.value
      const response = await fetch(fetchContactsUrl);
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
    <Pagination :current-page="currentPage" :per-page="perPage" :total-pages="totalPages" :maxVisibleButtons="maxVisibleButtons" :key="rerenderPagination" @pagechanged="onPageChange"/>
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