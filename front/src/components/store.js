import {ref, reactive} from 'vue'

export const store = reactive({
  contacts: [],
  addContact(contact) {
    const updated = this.contacts.find(x => x.id === contact.id);
    if (updated) {
      updated.name = contact.name;
      updated.surname = contact.surname;
      updated.email = contact.email;
      updated.contents = contact.contents;
    }
  },
  deleteContact(contact) {
    const foundIndex = this.contacts.findIndex(x => x.id === contact.id);
    if(foundIndex !== -1){
      this.contacts.splice(foundIndex, 1);
    }
  }
})