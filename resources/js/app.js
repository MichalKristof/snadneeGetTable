import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './bootstrap';
import '../css/app.css';

import {createApp} from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import TablesComponent from './components/TablesComponent.vue';

const appContainer = document.getElementById('app');

const app = createApp({});

(async () => {
    if(appContainer) {
        app.component('tables-component', TablesComponent);
        app.component('vue-date-picker', VueDatePicker);
        app.mount(appContainer);
    }
})();
