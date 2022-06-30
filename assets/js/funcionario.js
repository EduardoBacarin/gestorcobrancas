var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_funcionarios;

$(document).ready(function () {
  tabela_funcionarios = $("#tabela-funcionarios").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": true,
    "lengthMenu": [
      [10, 50, 75, 100],
      ['10', '50', '75', '100']
    ],
    "processing": true,
    "language": {
      "url": '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    },
    "ajax": base_url + "funcionario/listar",
    "columns": [{
      "width": "10%",
      "name": "Posição"
    }, {
      "width": "20%",
      "name": "Nome"
    }, {
      "width": "20%",
      "name": "Documento"
    }, {
      "width": "20%",
      "name": "E-Mail"
    },{
      "width": "20%",
      "name": "Telefone"
    },{
      "width": "10%",
      "name": "Ações"
    },
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 4],
      "className": 'dt-body-nowrap'
    }],

  });

  $('#formModalCadastrarFuncionario').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      nome_func: {
        validators: {
          notEmpty: {
            message: 'O nome do funcionario é obrigatório.'
          }
        }
      },
      email_func: {
        validators: {
          notEmpty: {
            message: 'O e-mail do funcionario é obrigatório.'
          }
        }
      },
      telefone_func: {
        validators: {
          notEmpty: {
            message: 'O telefone do funcionario é obrigatório.'
          }
        }
      },
    }
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
        url: base_url + 'funcionario/salvar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.retorno) {
            sucesso(data.msg);
            $('#modal-cadastra-funcionario').modal('hide');
            tabela_funcionarios.draw();
          } else {
            erro(data.msg);
          }
        }
      });
    });

});

$(document).on('click', '#btn-modal-cadastro', function () {
  limpa_campos('formModalCadastrarFuncionario');
  $('#codigo_usu').val(0);
  let senha_aleatoria = genPassword(8);
  $('#senha_func').val('').val(senha_aleatoria);
  $('#modal-cadastra-funcionario').modal('show');
});

$(document).on('click', '.item-excluir', function () {
  var nome = $(this).data('nome');
  var codigo = $(this).data('codigo');
  Swal.fire({
    title: 'Excluir Funcionário?',
    icon: 'warning',
    text: 'Deseja apagar o(a) funcionário ' + nome + '? Ele não poderá acessar mais o sistema.',
    showCancelButton: true,
    confirmButtonText: 'Apagar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: base_url + 'funcionario/inativar',
        type: 'POST',
        data: {
          codigo: codigo
        },
        dataType: 'json',
        success: function (data) {
          if (data.return) {
            Swal.fire('Excluído!', data.msg, 'success')
          } else {
            erro(data.msg);
          }
          tabela_funcionarios.draw();
        },
        error: function () {
          erro('Erro ao executar, atualize e tente novamente.');
        }

      });
    }
  })
});

function limpa_campos(form) {
  $('#' + form).trigger("reset");
};

function genPassword(passwordLength) {
  var chars = "0123456789abcdefghijklmnopqrstuvwxyz!@#$&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  var password = "";
  for (var i = 0; i <= passwordLength; i++) {
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber + 1);
  }
  return password;
}

function copyPassword() {
  var copyText = document.getElementById("password");
  copyText.select();
  copyText.setSelectionRange(0, 999);
  document.execCommand("copy");
  alert("copied to clipboard")
}