<template>
    <modal name="boardroom-modal" height="auto" :scrollable="true" @before-open="beforeOpen">
        <alv-form :action="form.action" :method="form.method" @after-done="afterDone"
                  :spinner="true" ref="form"
                  autocomplete="off" :data-object="boardroom">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <strong>Sala de juntas</strong>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        @click="$modal.hide('boardroom-modal')">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" class="form-control" placeholder="Nombre"
                           name="name"
                           :disabled="modalShow"
                           v-model="boardroom.name">
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
    name: "BoardroomModal",
    data() {
        return {
            form: {
                action: null,
                method: null
            },
            boardroom: {
                name: null
            },
            modalShow: false
        }
    },
    methods: {
        afterDone(response) {
            console.log(response)
            this.$modal.hide('boardroom-modal')
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
            Object.assign(this.boardroom, this.$options.data().boardroom)
            this.modalShow = typeof event.params.show !== "undefined"
            if (typeof event.params.id !== "undefined") {
                this.form.action = this.route('boardrooms.update', event.params);
                this.form.method = 'PUT';

                const params = {
                    columns: JSON.stringify(['name'])
                }
                axios.get(this.route('boardrooms.show', event.params), {params})
                    .then(response => {
                        this.boardroom = response.data
                    })
                    .catch(() => {
                        this.swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Algo ha ido mal',
                        })
                    })

            } else {
                this.form.action = this.route('boardrooms.store');
                this.form.method = 'POST';
            }
        }
    }
}
</script>
