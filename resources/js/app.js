require('./bootstrap');
require('./includes');

import {
    createApp
} from 'vue';
import store from './store'; // Импортируйте ваше хранилище Vuex
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const app = createApp({});

app.component('Multiselect', Multiselect);

app.component('tournament-table', require('./components/TournamentTable').default);
app.component('tournament-edit-table', require('./components/TournamentEditTable').default);
// Регистрируйте хранилище Vuex в приложении
app.use(store);

app.mount('#app');

