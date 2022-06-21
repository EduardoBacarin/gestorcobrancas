var base_url = $("#base_url").val();
var pagina   = $('#pagina').val();
var url = window.location;

/* SIDEBAR TREEVIEW ATIVO E INATIVO */
$('ul.nav-sidebar a').filter(function() {
    return this.href == url;
}).addClass('active');

$('ul.nav-treeview a').filter(function() {
    return this.href == url;
}).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
/* FIM SIDEBAR TREEVIEW ATIVO E INATIVO */

$(document).ready(function () {

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

function sucesso(msg){
    toastr.success(msg)
}

function info(msg){
    toastr.info(msg)
}

function erro(msg){
    toastr.error(msg)
}

function aviso(msg){
    toastr.warning(msg)
}