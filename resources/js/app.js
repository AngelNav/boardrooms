require('./bootstrap');

window.Vue = require('vue').default;
/*import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';*/
import components from "./components";
import {ServerTable} from "vue-tables-2"

Vue.use(ServerTable)

const app = new Vue({
    el: '#app',
    components: components
});
