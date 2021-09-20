export default {
    deleteDialog(handler) {
        this.$modal.show('dialog', {
            title: "Eliminar registro",
            text: "¿Desea eliminar el registro?",
            buttons: [
                {
                    title: "Cancelar",
                    handler: () => this.$modal.hide('dialog')
                },
                {
                    title: "Eliminar",
                    handler: handler
                }
            ]
        });
    }
}
