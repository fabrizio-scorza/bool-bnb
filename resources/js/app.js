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

const app = createApp({
    data() {
        return {
            selectedAmount: 0 
        }
    }
});

app.component("map-component", MapComponent);
app.component("address-component", AddressComponent);
app.component("homepage", Homepage);
app.component("advanced-search", AdvancedSearch);
app.component("payment-component", PaymentComponent);

app.mount("#app");
