require('./bootstrap');

window.Vue = require('vue').default;
import components from "./components";
import tablesConfig from './tables_config'
import {ServerTable} from "vue-tables-2"

Vue.use(ServerTable, tablesConfig.options, false, 'bootstrap4')

Vue.mixin({methods: {route}});
const app = new Vue({
    el: '#app',
    components: components
});
