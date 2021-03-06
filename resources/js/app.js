require('./bootstrap');

window.Vue = require('vue').default;
import components from "./components";
import tablesConfig from './tables_config'
import {ServerTable} from "vue-tables-2"
import VModal from "vue-js-modal"
import ModalFunctions from './modals'
import Swal from 'sweetalert2'
import alvue from '@myshell/alvue'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(ServerTable, tablesConfig.options, false, 'bootstrap4')
Vue.use(VModal, {dialog: true})
Vue.use(alvue);
Vue.component('datetime', Datetime);

Vue.mixin({
    data() {
        return {
            swal: Swal
        }
    },
    methods: {
        route,
        ...ModalFunctions,
    }
});
const app = new Vue({
    el: '#app',
    components: components
});
