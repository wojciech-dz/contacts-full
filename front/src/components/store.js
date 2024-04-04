import {ref, reactive} from 'vue'

export const store = reactive({
  contacts: [],
  addContact(contact) {
    this.contacts.push(contact)
  }
})