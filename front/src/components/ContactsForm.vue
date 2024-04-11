<script setup>
  import ContactsInput from './ContactsInput.vue';
  import { validEmail } from './tools.js';
  import {ref, computed, defineProps, defineEmits, watch} from 'vue'
  import axios from 'axios'
  import {store} from "@/components/store.js";

  const props = defineProps(['contact'])
  const emits = defineEmits(['saved'])

  const _id = ref('')
  const _name = ref('')
  const _surname = ref('')
  const _email = ref('')
  const _contents = ref('')

  const id = ref(props.contact ? props.contact.id : '')
  const name = ref(props.contact ? props.contact.name : '')
  const surname = ref(props.contact ? props.contact.surname : '')
  const email = ref(props.contact ? props.contact.email : '')
  const contents = ref(props.contact ? props.contact.contents : '')

  watch(() => props.contact, (newValue, oldValue) => {
    id.value = newValue.id;
    name.value = newValue.name;
    surname.value = newValue.surname;
    email.value = newValue.email;
    contents.value = newValue.contents;

    _email.value = !newValue.email;
  });

  const cantSave = computed(
    () => !name.value || !surname.value || !email.value || !contents.value || !validEmail(email.value)
  )

  function clearForm() {
    id.value = '';
    name.value = '';
    surname.value = '';
    email.value = '';
    contents.value = '';

    _email.value = null;
    emits('cleared')
  }
  async function saveForm() {
    try {
      const newContact = !id.value;
      const url = 'http://localhost:8000/contactform' + (!newContact ? '/' + id.value : '');
      const contactValues = {
        name: name.value,
        surname: surname.value,
        email: email.value,
        contents: contents.value
      };
      const response =
          newContact
              ? await axios.post(url, contactValues)
              : await axios.put(url, contactValues);
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
      <ContactsInput v-model="id" label="Id" type="text" disabled="id.value===''"/>
      <ContactsInput v-model="name" label="Imię" type="text"/>
      <ContactsInput v-model="surname" label="Nazwisko" type="text"/>
      <ContactsInput v-model="email" label="Adres email" type="email" />
      <ContactsInput v-model="contents" label="Wiadomość" type="text" />
      <div>
        <button type="button" class="btn btn-outline-success" :disabled="cantSave" @click="saveForm">Zapisz</button>
        <button type="button" class="btn btn-outline-danger" :disabled="cantSave" @click="clearForm">Nowy</button>
      </div>
    </form>
  </div>
  
  
  <div id="saved-contact-data" v-show="_email && _email">
    <table class="table table-sm table-success table-bordered">
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

  table {
    width: 80%;
    min-width: 250px;
    text-align: left;
    margin: 10px;
  }
</style>
