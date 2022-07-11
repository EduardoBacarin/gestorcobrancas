var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_cobrancas, tabela_parcelas;
var mes_selecionado = $('#mes_selecionado').val();
var ano_selecionado = $('#ano_selecionado').val();

$(document).ready(function () {
  tabela_cobrancas = $("#tabela-cobrancas").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": true,
    "autoWidth": false,
    "responsive": true,
    "lengthMenu": [
      [10, 50, 75, 100],
      ['10', '50', '75', '100']
    ],
    "processing": true,
    "language": {
      "url": '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    },
    "ajax": {
      url: base_url + "cobranca/listar/",
      'data': function (data) {
        data.mes_selecionado = mes_selecionado;
        data.ano_selecionado = ano_selecionado;
      }
    },
    "columns": [{
      "width": "5%",
      "name": "Posição"
    },
    {
      "width": "15%",
      "name": "Cliente"
    },
    {
      "width": "10%",
      "name": "Cidade",
    },
    {
      "width": "10%",
      "name": "Parcelas"
    },
    {
      "width": "10%",
      "name": "Taxa"
    },
    {
      "width": "10%",
      "name": "Tipo"
    },
    {
      "width": "5%",
      "name": "Total com Juros"
    },
    {
      "width": "10%",
      "name": "Emprestado"
    },
    {
      "width": "10%",
      "name": "Lucro"
    },
    {
      "width": "10%",
      "name": "Ações"
    }
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
      "className": 'dt-body-nowrap'
    }],

  });

  $('#formModalCadastrarCobranca').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      codigo_cli: {
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
      qtdparcelas_cob: {
        validators: {
          notEmpty: {
            message: 'A quantidade de parcelas é obrigatória.'
          }
        }
      },
      total_cob: {
        validators: {
          notEmpty: {
            message: 'O valor da dívida é obrigatória.'
          }
        }
      },
      diacobranca_cob: {
        validators: {
          notEmpty: {
            message: 'O dia da cobrança é obrigatório'
          }
        }
      },
      dialimite_cob: {
        validators: {
          notEmpty: {
            message: 'O dia limite de pagamento é obrigatório.'
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
        url: base_url + 'cobranca/salvar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.return) {
            sucesso(data.msg);
            $('#modal-cadastra-cobranca').modal('hide');
            tabela_cobrancas.draw();
          } else {
            erro(data.msg);
          }
        }
      });
    });
});

$(document).on('change', 'input[type=radio][name=tipocobranca_cob]', function () {
  if (this.value == 1) {
    $('.divDiario').hide();
    $('.divMensal').show();
  } else if (this.value == 2) {
    $('.divDiario').show();
    $('.divMensal').hide();
  }
});

$(document).on('change', 'input[type=radio][name=tipocalculo_cob]', function () {
  if (this.value == 1) {
    $('#valorparcela_cob').prop('disabled', false);
    $('#taxa_cob').prop('disabled', true);
  } else if (this.value == 2) {
    $('#valorparcela_cob').prop('disabled', true);
    $('#taxa_cob').prop('disabled', false);
  }
});

$(document).on('change', '#codigo_cli', function () {
  var documento = $(this).find(':selected').data('doc');
  var telefone = $(this).find(':selected').data('tel');

  $('#documento_cli').val(documento).trigger('input');
  $('#telefone_cli').val(telefone).trigger('input');
});


$(document).on('change', '#troca-mes', function () {
  $('#mes_selecionado').val($(this).find(':selected').val());
  mes_selecionado = $(this).find(':selected').val();
  tabela_cobrancas.draw();
});

$(document).on('change', '#troca-ano', function () {
  $('#ano_selecionado').val($(this).find(':selected').val());
  ano_selecionado = $(this).find(':selected').val();
  tabela_cobrancas.draw();
});

$(document).on('click', '#btn-modal-cadastro', function () {
  limpa_campos('formModalCadastrarCobranca');
  $('#codigo_cli').val(0);
  $('#modal-cadastra-cobranca').modal('show');
});

$(document).on('click', '.item-editar', function () {
  var codigo = $(this).data('codigo');
  limpa_campos('formModalCadastrarCobranca');
  $.ajax({
    url: base_url + 'cobranca/buscar',
    type: 'POST',
    data: { codigo: codigo },
    dataType: 'json',
    success: function (data) {
      if (data.return) {
        $('#modal-cadastra-cobranca').modal('show');
      } else {
        erro(data.msg);
      }
    },
    error: function () {
      erro('Erro ao buscar o cliente');
    }
  });
});


$(document).on('click', '.item-pago', function () {
  var codigo = $(this).data('codigo');
  var datalimite = $(this).data('limite');
  var valororiginal = $(this).data('valororiginal');
  var lucro = $(this).data('lucro').toFixed(2);
  var valor = $(this).data('valor').toFixed(2);
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear() + "-" + (month) + "-" + (day);

  limpa_campos('modal-marcar-pago');
  $('#modal-marcar-pago').modal('show');
  $('#datapago_par').val(today);
  $('#datalimite_par').val(datalimite);
  $('#codigo_par').val(codigo);
  $('#valororiginal').val(valororiginal);
  $('#valorpago_par').val(valor).trigger('input');
  $('#formModalMarcarPago').formValidation({
    framework: 'bootstrap',
    excluded: [':disabled', ':hidden', ':not(:visible)'],
    icon: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      datapago_par: {
        validators: {
          notEmpty: {
            message: 'A data de pagamento é obrigatória.'
          }
        }
      },
      valorpago_par: {
        validators: {
          notEmpty: {
            message: 'O valor pago é obrigatório.'
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
        url: base_url + 'cobranca/marcar_pago',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.return) {
            sucesso(data.msg);
            $('#modal-marcar-pago').modal('hide');
            tabela_parcelas.draw();
            limpa_campos('modal-marcar-pago');
          } else {
            erro(data.msg);
          }
        }
      });
    });
});

$(document).on('click', '.item-excluir', function () {
  var nome = $(this).data('nome');
  var codigo = $(this).data('codigo');
  Swal.fire({
    title: 'Excluir Cobrança',
    icon: 'warning',
    text: 'Deseja apagar esta cobrança?',
    showCancelButton: true,
    confirmButtonText: 'Apagar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: base_url + 'cobranca/inativar',
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
          tabela_cobrancas.draw();
        },
        error: function () {
          erro('Erro ao executar, atualize e tente novamente.');
        }

      });
    }
  })
});


$(document).on('click', '.item-jurosatraso', function () {
  var codigo = $(this).data('codigo');

  $.ajax({
    url: base_url + 'cobranca/calcula_juros',
    type: 'POST',
    data: {
      codigo: codigo
    },
    dataType: 'json',
    success: function (data) {
      if (data.return) {
        console.log(data);
        $('#modal-calcula-juros').modal('show');
        $('#taxadejuros_parcela').text((parseFloat(data.juros.taxa_cobrada) * 100) + '%')
        $('#valororiginal_parcela').text('R$ ' + parseFloat(data.juros.valor_parcela).toFixed(2));
        $('#valorcomjuros_parcela').text('R$ ' + parseFloat(data.juros.valor_final).toFixed(2));
        $('#diasatrasados_parcela').text(parseInt(data.juros.dias_atrasados) + ' dias');
        $('#tipodejuros_parcela').text(data.juros.tipo_juros);

      } else {
        erro(data.msg);
      }
      tabela_cobrancas.draw();
    },
    error: function () {
      erro('Erro ao executar, atualize e tente novamente.');
    }

  });
});



$(document).on('click', '.item-verparcelas', function () {
  var nome = $(this).data('nome');
  var codigo = $(this).data('codigo');
  $('#modal-lista-parcelas').modal('show');

  if ($.fn.DataTable.isDataTable('#tabela-parcelas')) {
    tabela_parcelas.destroy();
  }
  tabela_parcelas = $("#tabela-parcelas").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": false,
    "autoWidth": false,
    "responsive": true,
    "scrollX": true,
    "lengthMenu": [
      [10, 50, 75, 100],
      ['10', '50', '75', '100']
    ],
    "processing": true,
    "language": {
      "url": '//cdn.datatables.net/plug-ins/1.12.1/i18n/pt-BR.json'
    },
    "ajax": {
      url: base_url + "cobranca/listar_parcelas/",
      'data': function (data) {
        data.cobranca = codigo;
      }
    },
    "columns": [{
      "width": "5%",
      "name": "Posição"
    },
    {
      "width": "15%",
      "name": "Cliente"
    },
    {
      "width": "10%",
      "name": "Cidade",
    },
    {
      "width": "10%",
      "name": "Parcelas"
    },
    {
      "width": "10%",
      "name": "Taxa"
    },
    {
      "width": "10%",
      "name": "Taxa"
    },
    {
      "width": "10%",
      "name": "Tipo"
    },
    {
      "width": "5%",
      "name": "Total com Juros"
    },
    {
      "width": "10%",
      "name": "Emprestado"
    },
    ],
    "columnDefs": [{
      "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
      "className": 'dt-body-nowrap dt-head-nowrap'
    }],
  });
});

function limpa_campos(form) {
  $('#' + form).trigger("reset");
  $('#' + form).formValidation(options);
  $('#' + form).data('formValidation').resetForm();
};

function mascaraValor(valor) {
  valor = valor.toString().replace(/\D/g, "");
  valor = valor.toString().replace(/(\d)(\d{8})$/, "$1.$2");
  valor = valor.toString().replace(/(\d)(\d{5})$/, "$1.$2");
  valor = valor.toString().replace(/(\d)(\d{2})$/, "$1,$2");
  return valor
}