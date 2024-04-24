<template>
    <div>
        <div v-if="showModal" id="myModal" class="modal-custom">

        <div class="modal-content">
            <span @click="closeAddWorks" class="close">&times;</span>
            <h2>Aggiungi Lavoro</h2>
            <form @submit.prevent="submitCreate">
                <div class="container">
                    <div class="row mb-2 mt-4 ">
                        <input class="col-6" id="name" v-model="formCreate.name" type="text" placeholder="Nome">
                        <input class="col-2 offset-4" id="qty" v-model="formCreate.qty" type="text" placeholder="Quantità">
                    </div>
                    <div class="row mb-2">
                        <label for="agency">Seleziona agenzia:</label>
                        <multiselect id="agency" @select="loadPriceList" label="name" placeholder="Seleziona agenzia" class="col m-0" v-model="selectedAgency" :options="optionAgencies"></multiselect>
                    </div>
                    <div class="row mb-2">
                        <label for="products">Seleziona prodotto:</label>
                        <multiselect id="products" @select="loadPriceList" label="name" placeholder="Seleziona prodotti" class="col m-0" v-model="selectedProducts" :options="optionProducts"></multiselect>
                    </div>
                    <div class="row mb-2">
                        <label for="products">Seleziona listino:</label>
                        <multiselect id="products" label="name" placeholder="Seleziona prodotti" class="col m-0" v-model="selectedPriceLists" :options="optionPriceLists"></multiselect>
                    </div>
                </div>
                <input type="submit" value="Aggiungi">
            </form>
        </div>

        </div>
        <div class="container">
            <div class="row">
                <h1 class="col text-center">Lavori</h1>
            </div>
        </div>
        <div class="container mb-2 ml-0">
            <div class="row">
                <div class="col-1">
                    <button class="btn btn-primary btn-sm mr-3" type="button" @click="fetchData">Aggiorna</button>
                </div>
                <div class="col-1">
                    <button class="btn btn-success btn-sm" type="button" @click="addWorks">Crea</button>
                </div>
            </div>

        </div>

        <div class="container">
            <div>
                <table class="table">
                <thead>
                    <tr>
                        <th style="width: 10%">Azioni</th>
                        <th>Nome Lavoro</th>
                        <th>Agenzia</th>
                        <th>Prodotto</th>
                        <th>Listino</th>
                        <th>Quantità</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td>
                            <button type="button" class="btn btn-danger" @click="deleteWorks(item.id)">Elimina</button>
                        </td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.agency.name }}</td>
                        <td>{{ item.product.name }}</td>
                        <td v-if="item.pricelist == null">Nessun listino</td>
                        <td v-if="item.pricelist != null">{{ item.pricelist.name }}</td>
                        <td>{{ item.qty }}</td>
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
      selectedPriceLists: [],
      formCreate: {
        name: '',
        qty: '',
      },
      optionProducts: [],
      optionAgencies: [],
      optionPriceLists: []

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
        const response = await axios.get('/api/works'); 
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
    async loadPriceList() {
      try {
        this.selectedPriceLists = []
        const response = await axios.get('/api/price_list',{params:{agency_id: this.selectedAgency.id, product_id: this.selectedProducts.id}}); // Sostituisci con l'URL effettivo della tua API
        this.optionPriceLists = response.data
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    addWorks(){
        this.showModal = true;
    },
    closeAddWorks(){
        this.showModal = false;
        this.clearAddWorks()
    },    
    clearAddWorks(){
        this.formCreate.name = ''
        this.formCreate.qty = ''
        this.selectedAgency = []
        this.selectedProducts = []
        this.selectedWorks = []

    },
    async submitCreate() {
      try {
        if(!this.selectedPriceLists){
            await axios.post('/api/works',  {name: this.formCreate.name, qty: this.formCreate.qty, products_id: this.selectedProducts.id, agency_id: this.selectedAgency.id}); 
        }else{
            await axios.post('/api/works',  {name: this.formCreate.name, qty: this.formCreate.qty, products_id: this.selectedProducts.id, agency_id: this.selectedAgency.id, price_lists_id: this.selectedPriceLists.id}); 
        }
        this.closeAddWorks()
        this.fetchData()
        this.clearAddWorks()
      } catch (error) {
        alert(error);
      }
    },
    async deleteWorks(id){
        if(window.confirm("Sei sicuro di voler procedere?")){
            try {
            const response = await axios.delete('/api/works', {data:{id: id}});
            this.fetchData()
        } catch (error) {
            console.error('Error fetching data:', error);
        }
        }

    }
  }
}
</script>