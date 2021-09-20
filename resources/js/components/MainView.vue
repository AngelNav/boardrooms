<template>
    <component :is="currentComponent" @swap-component="swapComponent" :data="data"></component>
</template>

<script>
import BoardroomsTable from "./boardrooms/BoardroomsTable";
import ReservationsTable from "./reservations/ReservationsTable";

export default {
    name: "MainView",
    components: {BoardroomsTable, ReservationsTable},
    data() {
        return {
            data: {},
            currentComponent: 'BoardroomsTable'
        }
    },
    methods: {
        swapComponent(component, data) {
            this.data = data
            this.currentComponent = component
        }
    }
}
</script>
