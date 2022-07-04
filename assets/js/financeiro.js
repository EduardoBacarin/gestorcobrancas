var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_despesas, tabela_receitas;

$(document).ready(function () {
  tabela_despesas = $("#tabela-despesas").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": false,
    "responsive": true,
    "lengthMenu": [
      [10, 50, 75, 100],
      ['10', '50', '75', '100']
    ],
    "processing": true,
    "autoWidth": false,
    "language": {
      "url": '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    },
    "ajax": base_url + "financeiro/listar_despesas",
    "columns": [{
      "width": "5%",
      "name": "Posição"
    }, {
      "width": "10%",
      "name": "Data"
    }, {
      "width": "15%",
      "name": "Funcionário"
    }, {
      "width": "20%",
      "name": "Nome"
    }, {
      "width": "30%",
      "name": "Descrição"
    }, {
      "width": "10%",
      "name": "Valor"
    },
    {
      "width": "10%",
      "name": "Ações"
    }
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 5, 6],
      "className": 'dt-body-nowrap'
    }],
  });

  tabela_receitas = $("#tabela-receitas").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": true,
    "responsive": true,
    "lengthMenu": [
      [10, 50, 75, 100],
      ['10', '50', '75', '100']
    ],
    "processing": true,
    "autoWidth": false,
    "language": {
      "url": '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    },
    "ajax": base_url + "financeiro/listar_receitas",
    "columns": [{
      "width": "5%",
      "name": "Posição"
    }, {
      "width": "10%",
      "name": "Data"
    }, {
      "width": "15%",
      "name": "Funcionário"
    }, {
      "width": "20%",
      "name": "Nome"
    }, {
      "width": "30%",
      "name": "Descrição"
    }, {
      "width": "10%",
      "name": "Valor"
    },
    {
      "width": "10%",
      "name": "Ações"
    }
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 5, 6],
      "className": 'dt-body-nowrap'
    }],
  });

  $('#formModalCadastrarFinanceiro').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      data_fin: {
        validators: {
          notEmpty: {
            message: 'A data é obrigatória.'
          }
        }
      },
      nome_fin: {
        validators: {
          notEmpty: {
            message: 'O nome da transação é obrigatório.'
          }
        }
      },
      valor_fin: {
        validators: {
          notEmpty: {
            message: 'O valor da transação é obrigatório.'
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
        url: base_url + 'financeiro/salvar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.retorno) {
            sucesso(data.msg);
            $('#modal-cadastra-financeiro').modal('hide');
            tabela_despesas.draw();
            tabela_receitas.draw();
          } else {
            erro(data.msg);
          }
        }
      });
    });

});

$(document).on('click', '#btn-modal-cadastro', function () {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + (month) + "-" + (day);

  limpa_campos('formModalCadastrarFinanceiro');
  $('#codigo_fin').val(0);
  $('#modal-cadastra-financeiro').modal('show');
  $('#data_fin').val(today);
});

$(document).on('click', '.item-editar', function () {
  var codigo = $(this).data('codigo');
  limpa_campos('formModalCadastrarFinanceiro');
  $.ajax({
    url: base_url + 'financeiro/buscar',
    type: 'POST',
    data: { codigo: codigo },
    dataType: 'json',
    success: function (data) {
      if (data.retorno) {
        $('#modal-cadastra-financeiro').modal('show');
        $('#codigo_fin').val(data.dados.codigo_fin)
        $('#codigo_usu').val(data.dados.codigo_usu)
        $('#data_fin').val(data.dados.data_fin)
        $('#descricao_fin').val(data.dados.descricao_fin)
        $('#nome_fin').val(data.dados.nome_fin)
        $('#valor_fin').val(data.dados.valor_fin).trigger('input')

        tabela_despesas.draw();
        tabela_receitas.draw();
        if (data.dados.tipo_fin == 1){
          $("#tipo_fin-1").prop("checked", true);
        }else{
          $("#tipo_fin-2").prop("checked", true);
        }
       
      } else {
        erro(data.msg);
      }
    },
    error: function () {
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
          tabela_despesas.draw();
          tabela_receitas.draw();
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