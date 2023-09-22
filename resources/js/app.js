import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './bootstrap';
import '../css/app.css';

import {createApp} from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import ReservationComponent from './components/ReservationComponent.vue';

const appContainer = document.getElementById('app');

const app = createApp({});

(async () => {
    if(appContainer) {
        app.component('reservation-component', ReservationComponent);
        app.component('vue-date-picker', VueDatePicker);
        app.mount(appContainer);
    }
})();
