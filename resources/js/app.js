import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
])

import { createApp } from "vue";
import TestComponents from './Components/TestComponents.vue';

const app = createApp({});
app.component("test-components", TestComponents);
app.mount("#app");