<template>
  <div>
    <h2>Edit Item</h2>
    <form @submit.prevent="updateItem">
      <label for="editedItemName">Item Name:</label>
      <input type="text" id="editedItemName" v-model="editedItemName" required />
      <button type="submit">Update Item</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editedItemName: '',
    };
  },
  methods: {
    updateItem() {
      // todo: zaktualizuj to do endpointa edycji
      axios.post('https://api.example.com/items', { name: this.newItemName }).then(() => {
        // Clear the input field after adding the item
        this.newItemName = '';
        // Optionally, navigate to the list view
        this.$router.push('/');
      });
    },
  },
};
</script>