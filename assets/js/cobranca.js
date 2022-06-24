var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_cobrancas;
var mes_selecionado = $('#mes_selecionado').val();
var ano_selecionado = $('#ano_selecionado').val();

$(document).ready(function () {
  tabela_cobrancas = $("#tabela-cobrancas").DataTable({
    "ordering": false,
    "serverSide": true,
    "aaSorting": [],
    "order": [],
    "filter": false,
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
      "name": "Total",
    },
    {
      "width": "10%",
      "name": "Parcela"
    },
    {
      "width": "10%",
      "name": "Restante"
    },
    {
      "width": "10%",
      "name": "Prazo"
    },
    {
      "width": "10%",
      "name": "Status"
    },
    {
      "width": "5%",
      "name": "Taxa"
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
      "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
            message: 'O telefone do cliente é obrigatório.'
          }
        }
      },
      total_cob: {
        validators: {
          notEmpty: {
            message: 'O telefone do cliente é obrigatório.'
          }
        }
      },
      diacobranca_cob: {
        validators: {
          notEmpty: {
            message: 'O telefone do cliente é obrigatório.'
          }
        }
      },
      dialimite_cob: {
        validators: {
          notEmpty: {
            message: 'O telefone do cliente é obrigatório.'
          }
        }
      },
      taxa_cob: {
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
        url: base_url + 'cobranca/salvar',
        type: 'POST',
        data: formData,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
          if (data.retorno) {
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


$(document).on('blur', '#total_cob', function () {
  $('#totaldivida').html('R$' + $(this).val());
  calcula_juros();
});

$(document).on('change', '#qtdparcelas_cob', function () {
  calcula_juros();
});


$(document).on('blur', '#taxa_cob', function () {
  calcula_juros();
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
      if (data.retorno) {
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
            message: 'O nome do cliente é obrigatório.'
          }
        }
      },
      valorpago_par: {
        validators: {
          notEmpty: {
            message: 'O documento do cliente é obrigatório.'
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
            tabela_cobrancas.draw();
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

function limpa_campos(form) {
  $('#' + form).trigger("reset");
  $('#' + form).formValidation(options);
  $('#' + form).data('formValidation').resetForm();
};

function calcula_juros() {

  var valortotal = $('#total_cob').val();
  var juros = $('#taxa_cob').val();
  var parcelas = parseFloat($('#qtdparcelas_cob').val());

  valortotal = valortotal.split('.').join("");
  valortotal = parseFloat(valortotal.replace(',', '.'));
  juros = parseFloat(juros.split('%').join(""));


  juros = juros / 100;
  var valorjuros = valortotal * juros;
  var jurosaodia = valorjuros / 30;
  valorjuros = jurosaodia * (30 * parcelas);
  var montante = valorjuros + valortotal;
  var valorparcela = montante / parcelas;


  montante = parseFloat(montante).toFixed(2);
  valorparcela = parseFloat(valorparcela).toFixed(2)
  valorjuros = parseFloat(valorjuros).toFixed(2);
  jurosaodia = parseFloat(jurosaodia).toFixed(2);
  var formata_montante = mascaraValor(montante);
  var formata_valorjuros = mascaraValor(valorjuros);
  var formata_valorparcela = mascaraValor(valorparcela);

  $('#totalcomjuros').val(montante);
  $('#valorparcela').val(valorparcela);
  $('#valorlucro').val(valorjuros);
  $('#jurosaodia').val(jurosaodia);

  $('#txttotaljuros').html('R$' + (formata_montante ? formata_montante : '0,00'));
  $('#txtparcela').html('R$' + (formata_valorparcela ? formata_valorparcela : '0,00'));
  $('#txtlucro').html('R$' + (formata_valorjuros ? formata_valorjuros : '0,00'));
}

function mascaraValor(valor) {
  valor = valor.toString().replace(/\D/g, "");
  valor = valor.toString().replace(/(\d)(\d{8})$/, "$1.$2");
  valor = valor.toString().replace(/(\d)(\d{5})$/, "$1.$2");
  valor = valor.toString().replace(/(\d)(\d{2})$/, "$1,$2");
  return valor
}