<template>
    <div>
        <div v-if="showModal" id="myModal" class="modal-custom">

        <div class="modal-content">
            <span @click="closeAddPriceList" class="close">&times;</span> 
            <h2>Aggiungi Listino</h2>
            <form @submit.prevent="submitCreate">
                <div class="container">
                    <div class="row mb-2 mt-4 ">
                        <input class="col-6" id="name" v-model="formCreate.name" type="text" placeholder="Nome">
                        <input class="col offset-2" id="price" v-model="formCreate.price" type="text" placeholder="Prezzo">

                    </div>
                    <div class="row mb-2">
                        <label for="agency">Seleziona agenzia:</label>
                        <multiselect id="agency" label="name" placeholder="Seleziona agenzia" class="col m-0" v-model="selectedAgency" :options="optionAgencies"></multiselect>
                    </div>
                    <div class="row mb-2">
                        <label for="products">Seleziona prodotti:</label>
                        <multiselect id="products" multiple="true" label="name" placeholder="Seleziona prodotti" class="col m-0" v-model="selectedProducts" :options="optionProducts"></multiselect>
                    </div>
                </div>
                <input type="submit" value="Aggiungi">
            </form>
        </div>

        </div>
        <div class="container">
            <div class="row">
                <h1 class="col text-center">Listini</h1>
            </div>
        </div>
        <div class="container mb-2 ml-0">
            <div class="row">
                <div class="col-1">
                    <button class="btn btn-primary btn-sm mr-3" type="button" @click="fetchData">Aggiorna</button>
                </div>
                <div class="col-1">
                    <button class="btn btn-success btn-sm" type="button" @click="addPriceList">Crea</button>
                </div>
            </div>

        </div>

        <div class="container">
            <div>
                <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10%">Azioni</th>
                        <th>Nome Listino</th>
                        <th>Agenzia</th>
                        <th>Prodotti</th>
                        <th>Prezzo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td>
                            <button type="button" class="btn btn-danger" @click="deletePriceList(item.id)">Elimina</button>
                        </td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.agency.name }}</td>
                        <td ><p v-for="product in item.products_price_lists" :key="product.id">{{ product.products[0].name }}</p></td>
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
      selectedProducts: [],
      selectedAgency: [],
      formCreate: {
        name: '',
        price: '',
      },
      optionProducts: [],
      optionAgencies: []

    };
  },
  mounted(){
    this.fetchData()
    this.loadProducts()
    this.loadAgencies()
  },
  methods: {
    
    async fetchData() {
      try {
        const response = await axios.get('/api/price_list'); 
        this.data = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    async loadProducts() {
      try {
        const response = await axios.get('/api/products'); 
        this.optionProducts = response.data
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    async loadAgencies() {
      try {
        const response = await axios.get('/api/agencies'); 
        this.optionAgencies = response.data
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    addPriceList(){
        this.showModal = true;
    },
    closeAddPriceList(){
        this.showModal = false;
        this.clearAddPriceList()
    },    
    clearAddPriceList(){
        this.formCreate.name = ''
        this.formCreate.price = ''
        this.selectedAgency = []
        this.selectedProducts = []
    },
    async submitCreate() {
      try {
        const response = await axios.post('/api/price_list',  {name: this.formCreate.name, price: this.formCreate.price, products: this.selectedProducts, agency: this.selectedAgency}); 
        this.data = response.data;
        this.closeAddPriceList()
        this.fetchData()
        this.clearAddPriceList()
      } catch (error) {
        alert(error);
      }
    },
    async deletePriceList(id){
        if(window.confirm("Sei sicuro di voler procedere?")){
            try {
            const response = await axios.delete('/api/price_list', {data:{id: id}});
            this.fetchData()
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        }

    }
  }
}
</script>