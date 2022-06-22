var base_url = $("#base_url").val();
var pagina   = $('#pagina').val();
var url = window.location;

$('.cep').mask('00000-000');
$('.money').mask("#.##0,00", {reverse: true});
$('.percent').mask('##0,00%', {reverse: true});
var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('.celular').mask(behavior, options);

var CpfCnpjMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
},
cpfCnpjpOptions = {
onKeyPress: function(val, e, field, options) {
  field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
}
};
$('.cpfcnpj').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions)