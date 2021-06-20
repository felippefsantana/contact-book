<template>
  <div id="app">
    <div class="contactsContainer">
      <!-- <AddNewContactForm 
        v-on:reloadlist="getContactsList()"
      /> -->

      <div class="contactsForm">
        <input type="hidden" v-model="contact.id">
        <div>
          <label>Nome</label><br>
          <input type="text" v-model="contact.name">
        </div>
        <div>
          <label>E-mail</label><br>
          <input type="text" v-model="contact.email">
        </div>
        <div>
          <label>Telefone</label><br>
          <input type="text" v-model="contact.phone">
        </div>
        <button v-on:click="addContact()" v-if="!edit">Adicionar</button>
        <button v-on:click="updateContact(contact.id)" v-if="edit">Salvar alteraçoes</button>
      </div>

      <div 
        class="contactsList"
      >
        <div>
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(contact, index) in contacts" v-bind:key="index">
                <th>{{ contact.name }}</th>
                <th>{{ contact.email }}</th>
                <th>{{ contact.phone }}</th>
                <th>
                  <div>
                    <button v-on:click="showContact(contact.id)">Editar</button>
                    <button v-on:click="removeContact(contact.id)">Excluir</button>
                  </div>
                </th>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'App',
  components: {

  },
  data: function() {
    return {
      contact: {
        id: '',
        name: '',
        email: '',
        phone: ''
      },
      contacts: [],
      edit: false
    }
  },
  methods: {
    getContactsList() {
      axios.get('http://localhost:8000/api/contacts').then(response => {
        this.contacts = response.data;
      }).catch(error => {
        console.log(error);
      });
    },

    addContact() {
      if (this.contact.name == '' || this.contact.email == '' || this.contact.phone == '') {
        return;
      }
      axios.post('http://localhost:8000/api/contacts/create', {
        contact: this.contact
      }).then(response => {
        if(response.status == 201){
          this.contact.name = '';
          this.contact.email = '';
          this.contact.phone = '';
          this.getContactsList();
        }
      }).catch(error => {
        console.log(error);
      });
    },

    removeContact(id) {
      axios.delete('http://localhost:8000/api/contacts/delete/' + id).then(response => {
        console.log(response);
        this.getContactsList();
      }).catch(error => {
        console.log(error);
      });
    },

    showContact(id) {
      axios.get('http://localhost:8000/api/contacts/' + id).then(response => {
        console.log(response);
        this.contact.id = response.data.id;
        this.contact.name = response.data.name;
        this.contact.email = response.data.email;
        this.contact.phone = response.data.phone;
        this.edit = true;
      }).catch(error => {
        console.log(error);
      });
    },

    updateContact(id) {
      const contactData = {
        name: this.contact.name,
        email: this.contact.email,
        phone: this.contact.phone
      }

      console.log(contactData);

      axios.patch('http://localhost:8000/api/contacts/update/' + id, contactData).then(response => {
        console.log(response);
        this.contact.name = '';
        this.contact.email = '';
        this.contact.phone = '';
        this.edit = false;
        this.getContactsList();
      }).catch(error => {
        console.log(error);
      });
    }
  },
  created() {
    this.getContactsList();
  }
}
</script>

<style>
#app {
  height: 100vh;
  max-width: 992px;
  margin: 0 auto;

  display: flex;
  flex-direction: column;
  justify-content: center;
}

.contactsContainer {
  flex: 0;

  display: grid;
  grid-template-rows: 1fr 1fr;
  gap: 2.5rem;
}

.contactsForm {
  border: 1px solid rgb(158, 158, 158);
  padding: 1.5rem;

  font-size: 1.10rem;

  background: lightblue;
}

.contactsForm div {
  margin: 1rem 0;
}

.contactsForm div input{
  width: 100%;
  line-height: 1.5rem;
  border: none;
  border-radius: 5px;
}

.contactsList {
  background: coral;
  padding: 1.5rem;
}

.contactsList table {
  width: 100%;
}

.contactsList table tbody tr th {
  text-align: start;
}

</style>
