require('./bootstrap')
import { createApp } from 'vue'
import Navbar from './components/layout/Navbar.vue'
import Products from './components/Products.vue'
import Pricelist from './components/Pricelist.vue'
import Agencies from './components/Agencies.vue'
import Works from './components/Works.vue'
import {Multiselect} from 'vue-multiselect';
import 'vue-multiselect/dist//vue-multiselect.css';
import 'bootstrap/dist/css/bootstrap.css'

const app = createApp({});

app.component('Navbar', Navbar);
app.component('Products', Products);
app.component('Pricelist', Pricelist);
app.component('Agencies', Agencies);
app.component('Works', Works);
app.component('Multiselect', Multiselect);

app.mount('#app');
