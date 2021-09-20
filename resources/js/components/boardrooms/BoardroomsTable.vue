<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Salas de juntas</div>

                    <div class="card-body">
                        <v-server-table :url="route('boardrooms.index')" :columns="columns" :options="options"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            columns: ['id', 'name'],
            options: {
                headings: {
                    id: 'id',
                    name: 'Nombre'
                },
                sortable: ['id', 'name'],
            }
        }
    },
    methods: {
    },
}
</script>
