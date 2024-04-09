<script setup>
  import ContactsInput from './ContactsInput.vue';
  import { validEmail } from './tools.js';
  import {ref, computed, defineProps, defineEmits, onMounted} from 'vue'
  import axios from 'axios'
  import {store} from "@/components/store.js";

  defineProps(['contact'])
  const emits = defineEmits(['saved'])

  const id = ref('')
  const name = ref('')
  const surname = ref('')
  const email = ref('')
  const contents = ref('')
  const _id = ref('')
  const _name = ref('')
  const _surname = ref('')
  const _email = ref('')
  const _contents = ref('')

  const cantSave = computed(
    () => !name.value || !surname.value || !email.value || !contents.value || !validEmail(email.value)
  )

  function onMounted() {
    this.id = contact.id;
    this.name = contact.name;
    this.surname= contact.surname;
    this.email= contact.email;
    this.contents= contact.contents;
  }
  async function saveForm() {
    debugger;
    try {
      const response = await axios.post('http://localhost:8000/contactform', {
            name: name.value,
            surname: surname.value,
            email: email.value,
            contents: contents.value,
          });
      _id.value = response.data.id
      _name.value = response.data.name
      _surname.value = response.data.surname
      _email.value = response.data.email
      _contents.value = response.data.contents

      emits('saved', {
        id: _id.value,
        name: _name.value,
        surname: _surname.value,
        email: _email.value,
        contents: _contents.value
      })
    } catch (error){
      console.log(error)
    }
  }
</script>

<template>
  <div class="form">
    <form @submit.prevent="submitForm">
      <ContactsInput v-model="name" label="Imię" type="text"/>
      <ContactsInput v-model="surname" label="Nazwisko" type="text"/>
      <ContactsInput v-model="email" label="Adres email" type="email" />
      <ContactsInput v-model="contents" label="Wiadomość" type="text" />
      <button type="button" class="btn btn-success" :disabled="cantSave" @click="saveForm">Zapisz</button>
    </form>
  </div>
  
  
  <div v-show="_email && _email">
    <table>
        <tr><td>Id</td><td>{{_id && _id}}</td></tr>
        <tr><td>Imię</td><td>{{_name && _name}}</td></tr>
        <tr><td>Nazwisko</td><td>{{_surname && _surname}}</td></tr>
        <tr><td>Adres email</td><td>{{_email && _email}}</td></tr>
        <tr><td>Wiadomość</td><td>{{_contents && _contents}}</td></tr>
    </table>
  </div>

</template>

<script>
export default {
  name: 'ContactsForm',
  setup() {
    provide('updated', {
        name: 'Dolores',
        surname: 'Saneskobar',
        email: 'dolo@san.escobar',
        contents: 'hasta la vista'
    })
  }
}
</script>

<style scoped>
  form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1rem;

    min-width: 250px;
    width: 80%;
    margin: 10px;
    margin-bottom: 20px;
  }

  button {
    width: 100px;
  }

  button:hover {
    background-color: #059862
  }
</style>
