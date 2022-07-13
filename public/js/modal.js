
//RR Item delete close




window.addEventListener('close-modalRR', event => {
    $('#deleteModalRR').modal('hide');
});
window.addEventListener('close-modalSupplier', event => {
    $('#newSupplierModal').modal('hide');
});


window.addEventListener('open-modalRR', event => {
    $('#previewFinalizeModalRR').modal('show');
});