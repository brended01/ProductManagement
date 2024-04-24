<template>
    <div>
        <div v-if="showModal" id="myModal" class="modal-custom">

        <!-- Contenuto del modal -->
        <div class="modal-content">
            <span @click="closeAddAgency" class="close">&times;</span> <!-- Button per chiudere il modal -->
            <h2>Aggiungi Agenzia</h2>
            <form @submit.prevent="submitCreate">
                <div class="container">
                    <div class="row mb-2 mt-4">
                        <input class="col-6" id="name" v-model="formCreate.name" type="text" placeholder="Nome">
                    </div>
                </div>
                <input type="submit" value="Aggiungi">
            </form>
        </div>

        </div>
        <div class="container">
            <div class="row">
                <h1 class="col text-center">Agenzie</h1>
            </div>
        </div>
        <div class="container mb-2 ml-0">
            <div class="row">
                <div class="col-1">
                    <button class="btn btn-primary btn-sm mr-3" type="button" @click="fetchData">Aggiorna</button>
                </div>
                <div class="col-1">
                    <button class="btn btn-success btn-sm" type="button" @click="addAgency">Crea</button>
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
                        <th>Giacenza</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td>
                            <button type="button" class="btn btn-danger" @click="deleteAgency(item.id)">Elimina</button>
                        </td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.works_sum_qty }}</td>
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
        name: ''
      }
    };
  },
  mounted(){
    this.fetchData()
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/agencies');
        this.data = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    async submitCreate() {
      try {
        const response = await axios.post('/api/agencies',  {name: this.formCreate.name}); 
        this.data = response.data;
        this.closeAddAgency()
        this.fetchData()
      } catch (error) {
        console.log(error);
      }
    },
    addAgency(){
        this.showModal = true;
    },
    closeAddAgency(){
        this.showModal = false;
        this.clearAddAgency();
    },
    clearAddAgency(){
        this.formCreate.name = ''
    },
    async deleteAgency(id){
        if(window.confirm("Sei sicuro di voler procedere?")){
            try {
            const response = await axios.delete('/api/agencies', {data:{id: id}});
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