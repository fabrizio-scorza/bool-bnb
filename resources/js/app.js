import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
]);

import { createApp } from "vue";
import MapComponent from './Components/MapComponent.vue';
import AddressComponent from './Components/AddressComponent.vue';
import Homepage from './Pages/Homepage.vue';
import AdvancedSearch from './Pages/AdvancedSearch.vue';
import PaymentComponent from './Components/PaymentComponent.vue';

// Crea l'istanza Vue e definisci i dati
const app = createApp({
    data() {
        return {
            selectedAmount: 0 // Definisci il dato che vuoi condividere
        }
    }
});

// Registra i componenti globalmente
app.component("map-component", MapComponent);
app.component("address-component", AddressComponent);
app.component("homepage", Homepage);
app.component("advanced-search", AdvancedSearch);
app.component("payment-component", PaymentComponent);

// Monta l'app Vue
app.mount("#app");
