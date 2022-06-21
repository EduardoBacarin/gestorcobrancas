var base_url = $("#base_url").val();

$(document).ready(function () {

  $('input[name="tipo_usuario"]').on('click', function(){
    var valor = $(this).val();
    if (valor == 1){
      $('#dados_laboratorio').hide();
    }else if(valor == 2){
      $('#dados_laboratorio').show();
    }
  });

  $('#cep_user').on('blur', function(){
    var cep = $(this).val();
    $('#rua_user').val('...');
    $('#bairro_user').val('...');
    $('#cidade_user').val('...');
    $('#estadouf_user').val('...');

    $.getJSON( "https://ms.mook.com.br/cep/" + cep, function( data ) {
        $('#rua_user').val(data.logradouro);
        $('#bairro_user').val(data.bairro);
        $('#cidade_user').val(data.cidade);
        $('#estadouf_user').val(data.estado);
        $('#numero_user').focus();
      });
    });

  $('#FormCadastroUsuario').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {

    }
  })
  .on('success.form.fv', function (e) {
    e.preventDefault();

    var $form = $(e.target),
        params = $form.serializeArray(),
        formData = new FormData();


    $.each(params, function (i, val) {
        formData.append(val.name, val.value);
    });

    $.ajax({
        url: base_url + 'login/registrar_usuario',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.retorno) {

            } else {
  
            }
        }
    });
  });
});