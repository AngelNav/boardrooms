<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Salas de juntas</div>

                    <div class="card-body">
                        <v-server-table :url="route('boardrooms.index')" :columns="columns" :options="options"
                                        ref="table">

                            <div slot="beforeTable" class="mb-1 inline float-right">
                                <button type="button" class="btn btn-info"
                                        @click="$modal.show('boardroom-modal', {})">
                                    Nueva sala de juntas
                                </button>
                            </div>

                            <div slot="actions" slot-scope="props" class="text-center">
                                <button class="btn btn-primary"
                                        title="Mostrar"
                                        @click="show(props.row.id)">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn btn-warning"
                                        title="Editar"
                                        @click="edit(props.row.id)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="btn btn-danger"
                                        title="Eliminar"
                                        @click="erase(props.row.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button class="btn btn-info"
                                        title="Agendar"
                                        @click="reserve('ReservationsTable', props.row)">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </div>
                        </v-server-table>
                    </div>
                </div>
            </div>
        </div>
        <boardroom-modal @created="refreshTable"/>
        <v-dialog/>
    </div>
</template>

<script>
import BoardroomModal from "./BoardroomModal";

export default {
    components: {BoardroomModal},
    data() {
        return {
            columns: ['id', 'name', 'actions'],
            options: {
                headings: {
                    id: 'id',
                    name: 'Nombre',
                    actions: 'Acciones'
                },
                sortable: ['id', 'name'],
            }
        }
    },
    methods: {
        refreshTable() {
            this.$refs.table.refresh();
            this.$modal.hide('dialog');
        },
        reserve(component, data) {
            this.$emit('swap-component', component, data)
        },
        edit(id) {
            this.$modal.show('boardroom-modal', {id: id})
        },

        show(id) {
            this.$modal.show('boardroom-modal', {id: id, show: true})
        },
        erase(id) {
            this.deleteDialog(() => {
                axios.delete(this.route('boardrooms.destroy', id)).then(
                    response => {
                        this.refreshTable()
                        this.swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                );
            })
        }
    },
}
</script>
