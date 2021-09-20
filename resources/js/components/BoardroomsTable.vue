<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Salas de juntas</div>

                    <div class="card-body">
                        <v-server-table url="/people" :columns="columns" :options="options"/>
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
            columns: ['id', 'name', 'age'],
            options: {
                // see the options API
            }
        }
    },
    created() {
        console.info(this.route('boardrooms.index'))
    }
}
</script>
