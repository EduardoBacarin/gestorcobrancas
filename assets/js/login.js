var base_url = $("#base_url").val();
var avisos   = "Obrigatório."
$(document).ready(function () {

  $('#FormLogin').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      email_user: {
        validators: {
            notEmpty: {
                message: avisos
            }
        }
      },
      senha_user: {
        validators: {
            notEmpty: {
                message: avisos
            }
        }
      }
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
        url: base_url + 'login/entrar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.retorno == false) {
              erro('Usuário ou Senha Inválida');
            }else{
              window.location.replace('dashboard')
            }
        }
    });
  });
});