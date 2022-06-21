var base_url = $("#base_url").val();
var pagina = $('#pagina').val();
var url = window.location;

/* SIDEBAR TREEVIEW ATIVO E INATIVO */
$('ul.nav-sidebar a').filter(function () {
    return this.href == url;
}).addClass('active');

$('ul.nav-treeview a').filter(function () {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
/* FIM SIDEBAR TREEVIEW ATIVO E INATIVO */

$(document).ready(function () {

});


$(document).on('blur', '.cep', function () {
    var cep = $(this).val();
    $('.logradouro').val('...');
    $('.bairro').val('...');
    $('.cidade').val('...');
    $('.estado').val('...');

    $.getJSON("https://ms.mook.com.br/cep/" + cep, function (data) {
        if (data.erro){
            erro('CEP não encontrado')
            $('.logradouro').val('');
            $('.bairro').val('');
            $('.cidade').val('');
            $('.estado').val('');
            $('.cep').focus();
        }else{
            $('.logradouro').val(data.logradouro);
            $('.bairro').val(data.bairro);
            $('.cidade').val(data.cidade);
            $('.estado').val(data.estado);
            $('.numero').focus();
        }
    });
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function sucesso(msg) {
    toastr.success(msg)
}

function info(msg) {
    toastr.info(msg)
}

function erro(msg) {
    toastr.error(msg)
}

function aviso(msg) {
    toastr.warning(msg)
}