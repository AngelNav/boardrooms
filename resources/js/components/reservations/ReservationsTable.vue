<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Reservaciones <b>{{ data.name }}</b></div>

                    <div class="card-body">
                        <v-server-table :url="route('reservations.index',{boardroomId: data.id})" :columns="columns"
                                        :options="options"
                                        ref="table">

                            <div slot="beforeTable" class="mb-1 inline float-right">
                                <button type="button" class="btn btn-secondary"
                                        @click="$emit('swap-component','BoardroomsTable')">
                                    Regresar
                                </button>
                                <button type="button" class="btn btn-info"
                                        @click="$modal.show('reservation-modal', {})">
                                    Reservar
                                </button>
                            </div>

                            <div slot="active" slot-scope="props" class="text-center">
                                <span class="badge" :class="{
                                    'badge-success': props.row.active,
                                    'badge-danger': !props.row.active,
                                    }">{{ props.row.active ? 'Activa' : 'Vencida' }}</span>
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
                                <button class="btn btn-danger"
                                        title="Cancelar"
                                        @click="cancel(props.row.id)">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </v-server-table>
                    </div>
                </div>
            </div>
        </div>
        <reservation-modal @created="refreshTable" :data="data"/>
        <v-dialog/>
    </div>
</template>

<script>
import ReservationModal from "./ReservationModal";

export default {
    name: "ReservationsTable",
    components: {ReservationModal},
    props: {
        data: {
            type: Object
        }
    },
    data() {
        return {
            columns: ['id', 'start_date', 'end_date', 'active', 'actions'],
            options: {
                headings: {
                    id: 'id',
                    start_date: 'Inicio',
                    end_date: 'Fin',
                    active: 'Estado',
                    actions: 'Acciones'
                },
                sortable: ['id', 'name', 'start_date', 'end_date', 'active'],
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
        cancel(id){
            this.swal.fire({
                title: '¿Desea cancelar la reserva?',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Si, cancelar la reserva',
                cancelButtonText: 'No cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.patch(this.route('reservations.cancel', id)).then(response => {
                        this.swal.fire(response.data.message, '', 'success')
                        this.refreshTable()
                    })
                }
            })
        },
        edit(id) {
            this.$modal.show('reservation-modal', {id: id})
        },

        show(id) {
            this.$modal.show('reservation-modal', {id: id, show: true})
        },
        erase(id) {
            this.deleteDialog(() => {
                axios.delete(this.route('reservations.destroy', id)).then(
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
