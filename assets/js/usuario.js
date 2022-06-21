var base_url = $("#base_url").val();
var avisos = 'Obrigatório. ';

$('#navmain-cadastros').addClass('menu-open');

$(document).ready(function () {

  $('#cep').on('blur', function () {
    var cep = $(this).val();
    $('#logradouro').val('...');
    $('#bairro').val('...');
    $('#cidade').val('...');
    $('#estado').val('...');

    $.getJSON("https://ms.mook.com.br/cep/" + cep, function (data) {
      $('#logradouro').val(data.logradouro);
      $('#bairro').val(data.bairro);
      $('#cidade').val(data.cidade);
      $('#estado').val(data.estado);
      $('#numero').focus();
    });
  });

  $('#formAlterarUsuario').formValidation({
      framework: 'bootstrap',
      excluded: [':disabled', ':hidden', ':not(:visible)'],
      icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {}
    })
    .on('success.form.fv', function (e) {
      e.preventDefault();

      var $form = $(e.target),
        params = $form.serializeArray(),
        formData = new FormData();

      // $form.find('[type="submit"]').attr('disabled', true);

      $.each(params, function (i, val) {
        formData.append(val.name, val.value);
      });

      $.ajax({
        url: base_url + 'usuario/salvar_usuario',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.retorno) {
            sucesso(data.msg);
          } else {
            erro(data.msg);
          }
        }
      });
    });
});