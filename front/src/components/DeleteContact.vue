<template>
  <div>
    <h2>Delete Item</h2>
    <p>Are you sure you want to delete this item?</p>
    <button @click="confirmDelete">Yes</button>
    <button @click="cancelDelete">No</button>
  </div>
</template>

<script>
export default {
  methods: {
    confirmDelete() {
      // todo: zaktualizuj to do endpointa usuwania
      axios.post('https://api.example.com/items', { name: this.newItemName }).then(() => {
        // Clear the input field after adding the item
        this.newItemName = '';
        // Optionally, navigate to the list view
        this.$router.push('/');
      });
    },
    cancelDelete() {
      // Navigate back to the list view or close the modal
    },
  },
};
</script>