import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

import { createApp } from "vue";
import MapComponent from './Components/MapComponent.vue';

const app = createApp({});
app.component("map-component", MapComponent);
app.mount("#app");