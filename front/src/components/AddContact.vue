<template>
  <div>
    <h2>Add New Item</h2>
    <form @submit.prevent="addItem">
      <label for="itemName">Item Name:</label>
      <input type="text" id="itemName" v-model="newItemName" required />
      <button type="submit">Add Item</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      newItemName: '',
    };
  },
  methods: {
    addItem() {
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