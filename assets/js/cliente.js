var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_clientes;

$(document).ready(function () {
  tabela_clientes = $("#tabela-clientes").DataTable({
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
    "ajax": base_url + "cliente/listar",
    "columns": [{
      "width": "5%",
      "name": "Posição"
    },
    {
      "width": "15%",
      "name": "Nome"
    },
    {
      "width": "15%",
      "name": "Documento",
    },
    {
      "width": "15%",
      "name": "Telefone"
    },
    {
      "width": "25%",
      "name": "Endereço"
    },
    {
      "width": "15%",
      "name": "Cidade"
    },
    {
      "width": "10%",
      "name": "Ações"
    }
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 4],
      "className": 'dt-body-nowrap'
    }],

  });

  $('#formModalCadastrarCliente').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      nome_cli: {
        validators: {
          notEmpty: {
            message: 'O nome do cliente é obrigatório.'
          }
        }
      },
      documento_cli: {
        validators: {
          notEmpty: {
            message: 'O documento do cliente é obrigatório.'
          }
        }
      },
      telefone_cli: {
        validators: {
          notEmpty: {
            message: 'O telefone do cliente é obrigatório.'
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
        url: base_url + 'cliente/salvar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.retorno) {
            sucesso(data.msg);
          $('#modal-cadastra-cliente').modal('hide');
            tabela_clientes.draw();
          } else {
            erro(data.msg);
          }
        }
      });
    });

});

$(document).on('click', '#btn-modal-cadastro', function () {
  limpa_campos('formModalCadastrarCliente');
  $('#codigo_cli').val(0);
  $('#modal-cadastra-cliente').modal('show');
});

$(document).on('click', '.item-editar', function () {
  var codigo = $(this).data('codigo');
  limpa_campos('formModalCadastrarCliente');
  $.ajax({
    url: base_url + 'cliente/buscar',
    type: 'POST',
    data: { codigo: codigo },
    dataType : 'json',
    success: function(data) {
      if(data.retorno){
        $('#modal-cadastra-cliente').modal('show');
        $('#codigo_cli').val(data.dados.codigo_cli);
        $('#nome_cli').val(data.dados.nome_cli);
        $('#documento_cli').val(data.dados.documento_cli).trigger('input');
        $('#telefone_cli').val(data.dados.telefone_cli).trigger('input');
        $('#email_cli').val(data.dados.email_cli);
        $('#cep_cli').val(data.dados.cep_cli).trigger('input');
        $('#endereco_cli').val(data.dados.endereco_cli);
        $('#numero_cli').val(data.dados.numero_cli);
        $('#bairro_cli').val(data.dados.bairro_cli);
        $('#complemento_cli').val(data.dados.complemento_cli);
        $('#cidade_cli').val(data.dados.nome_cid);
        $('#estado_cli').val(data.dados.uf_est);
      }else{
        erro(data.msg);
      }
    },
    error: function(){
      erro('Erro ao buscar o cliente');
    }
  });
});

$(document).on('click', '.item-excluir', function () {
  var nome = $(this).data('nome');
  var codigo = $(this).data('codigo');
  Swal.fire({
      title: 'Excluir Cliente',
      icon: 'warning',
      text: 'Deseja apagar o(a) cliente ' + nome + '?',
      showCancelButton: true,
      confirmButtonText: 'Apagar',
      cancelButtonText: 'Cancelar',
      reverseButtons: true,
  }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
              url: base_url + 'cliente/inativar',
              type: 'POST',
              data: {
                  codigo: codigo
              },
              dataType: 'json',
              success: function (data) {
                  if (data.retorno) {
                      Swal.fire('Excluído!', data.msg, 'success')
                  } else {
                      erro(data.msg);
                  }
                  tabela_clientes.draw();
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