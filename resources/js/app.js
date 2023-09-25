import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './bootstrap';
import '../css/app.css';

import {createApp} from 'vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import ReservationComponent from './components/ReservationComponent.vue';
import DateComponent from "./components/DateComponent.vue";
import TimeComponent from "./components/TimeComponent.vue";
import TableComponent from "./components/TableComponent.vue";

const appContainer = document.getElementById('app');

const app = createApp({});

(async () => {
    if(appContainer) {
        app.component('reservation-component', ReservationComponent);
        app.component('date-component', DateComponent);
        app.component('time-component', TimeComponent);
        app.component('table-component', TableComponent);
        app.component('vue-date-picker', VueDatePicker);
        app.mount(appContainer);
    }
})();
