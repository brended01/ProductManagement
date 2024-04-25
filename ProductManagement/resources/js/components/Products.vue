<template>
    <div>
        <div v-if="showModal" id="myModal" class="modal-custom">

        <div class="modal-content">
            <span @click="closeAddProduct" class="close">&times;</span>
            <h2>Aggiungi Prodotto</h2>
            <form @submit.prevent="submitCreate">
                <div class="container">
                    <div class="row mb-2 mt-4 ">
                        <input class="col-6" id="name" v-model="formCreate.name" type="text" placeholder="Nome">
                        <input class="col offset-2" id="price" v-model="formCreate.price" type="number" placeholder="Prezzo">
                    </div>
                </div>
                <input type="submit" value="Aggiungi">
            </form>
        </div>

        </div>
        <div class="container">
            <div class="row">
                <h1 class="col text-center">Prodotti</h1>
            </div>
        </div>
        <div class="container mb-2 ml-0">
            <div class="row">
                <div class="col-1">
                    <button class="btn btn-primary btn-sm mr-3" type="button" @click="fetchData">Aggiorna</button>
                </div>
                <div class="col-1">
                    <button class="btn btn-success btn-sm" type="button" @click="addProduct">Crea</button>
                </div>
            </div>

        </div>


        <div class="container">
            <div>
                <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10%">Azioni</th>
                        <th>Nome</th>
                        <th>Prezzo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td>
                            <button type="button" class="btn btn-danger" @click="deleteProduct(item.id)">Elimina</button>
                        </td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.price }}€</td>
                    </tr>
                </tbody>

            </table>
            </div>
        </div>
        

       


    
    </div>

</template>
<script>
import axios from 'axios';

export default {
    data() {
    return {
      data: [],
      showModal: false,
      formCreate: {
        name: '',
        price: ''
      }
    };
  },
  mounted(){
    this.fetchData()
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/products');
        this.data = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    closeAddProduct(){
        this.showModal = false;
        this.clearAddProduct()
    },  
    clearAddProduct(){
        this.formCreate.name = ''
        this.formCreate.price = ''
    },  
    async submitCreate() {
      try {
        const response = await axios.post('/api/products',  {name: this.formCreate.name, price: this.formCreate.price}); 
        this.data = response.data;
        this.closeAddProduct()
        this.fetchData()
      } catch (error) {
        alert(error);
      }
    },
    addProduct(){
        this.showModal = true;
    },
    async deleteProduct(id){
        if(window.confirm("Sei sicuro di voler procedere?")){
            try {
            const response = await axios.delete('/api/products', {data:{id: id}}); 
            this.data = response.data;
            this.fetchData()
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        }

    }
  }
}
</script>