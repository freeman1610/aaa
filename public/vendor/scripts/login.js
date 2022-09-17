$("#frmAcceso").on('submit', function (e) {
    e.preventDefault();

    let datos = $('#frmAcceso').serialize();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $.ajax({

        method: 'POST',
        url: 'login',
        data: datos,

        success: function (res) {

            switch (res.respuesta) {
                case '200':
                    location.reload()
                    break;
                case '401':
                    toastr.error('Usuario Desactivado');
                    break;
                case '404':
                    toastr.error('Usuario y/o Password incorrectos o Usuario Desactivado')
                    break;
            }

        },

        error: function (err) {
            toastr.error(err.responseJSON.message);
        }

    });


});
if (localStorage.getItem('dark-mode') == 'enabled') {
    document.body.classList.toggle('dark-mode');
}