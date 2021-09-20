<template>
    <modal name="reservation-modal" height="auto" :scrollable="true" @before-open="beforeOpen">
        <alv-form :action="form.action" :method="form.method" @after-done="afterDone"
                  :spinner="true" ref="form"
                  autocomplete="off" :data-object="reservation">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <strong>Reservación</strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        @click="$modal.hide('reservation-modal')">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Inicio</label>
                            <datetime type="datetime" name="start_date" v-model="reservation.start_date"
                                      :disabled="modalShow"></datetime>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fin</label>
                            <datetime type="datetime" name="end_date" v-model="reservation.end_date"
                                      :disabled="modalShow"></datetime>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Id sala</label>
                            <input class="form-control" type="text" name="boardroom_id"
                                   v-model="reservation.boardroom_id" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" v-if="!modalShow">Guardar</button>
            </div>
        </alv-form>
    </modal>
</template>

<script>
export default {
    name: "ReservationModal",
    props: {
        data: {
            type: Object
        }
    },
    data() {
        return {
            form: {
                action: null,
                method: null
            },
            reservation: {
                start_date: null,
                end_date: null,
                boardroom_id: null,
            },
            modalShow: false
        }
    },
    methods: {
        afterDone(response) {
            this.$modal.hide('reservation-modal')
            this.$emit('created')
            this.swal.fire({
                position: 'center',
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500
            })
        },
        beforeOpen(event) {
            Object.assign(this.reservation, this.$options.data().reservation)
            this.modalShow = typeof event.params.show !== "undefined"
            if (typeof event.params.id !== "undefined") {
                this.form.action = this.route('reservations.update', event.params);
                this.form.method = 'PUT';

                const params = {
                    columns: JSON.stringify(['start_date', 'end_date'])
                }
                axios.get(this.route('reservations.show', event.params), {params})
                    .then(response => {
                        this.reservation = response.data
                        this.reservation.boardroom_id = this.data.id
                    })
                    .catch(() => {
                        this.swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo ha ido mal',
                        })
                    })

            } else {
                this.form.action = this.route('reservations.store');
                this.form.method = 'POST';
            }
        }
    }
}
</script>
