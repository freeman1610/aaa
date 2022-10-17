$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#btn-ver-chat").on("click", function () {
    $("#divChat").addClass('show-chat')
    $("#cerrarChat").addClass('show-button-chat')
})
$("#cerrarChat").on("click", function () {
    $("#divChat").removeClass('show-chat')
    $("#cerrarChat").removeClass('show-button-chat')
})

function buscar(texto) {

    $msg = '<div class="user-inbox inbox"><div class="msg-header"><p class="text-white">' + texto + '</p></div></div>';
    $(".form").append($msg);

    // iniciar el código ajax
    $.ajax({
        url: 'chat_bot_welcome',
        type: 'POST',
        data: 'text=' + texto,
        success: function (result) {
            $replay = '<div class="bot-inbox inbox"><div class="icon"><img src="vendor/images/lagarra.png" width="30"></div><div class="msg-header"><p>' + result + '</p></div></div>';
            $(".form").append($replay);
            // cuando el chat baja, la barra de desplazamiento llega automáticamente al final
            $(".form").scrollTop($(".form")[0].scrollHeight);
        }
    });

}
$.ajax({
    url: 'chat_bot_welcome_init',
    type: 'POST',
    success: function (res) {
        $replay = '<div class="bot-inbox inbox"><div class="icon"><img src="vendor/images/lagarra.png" width="30"></div><div class="msg-header"><p>' + res.saludo + '</p></div></div>'
        $('.form').append($replay)
        $('#preguntasTr').append(res.preguntas)
    }
});