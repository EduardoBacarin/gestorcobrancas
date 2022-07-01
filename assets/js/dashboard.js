var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_vencidos;

$(document).ready(function () {
  tabela_vencidos = $("#tabela-vencidos").DataTable({
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
    "ajax": {
      url: base_url + "dashboard/listar_vencidos",
      'data': function (data) {

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
      "name": "Emprestado",
    },
    {
      "width": "10%",
      "name": "Valor da Parcela"
    },
    {
      "width": "10%",
      "name": "Parcelas"
    },
    {
      "width": "10%",
      "name": "Data de Vencimento"
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
      "targets": [0, 1, 2, 3, 4, 5, 6, 7],
      "className": 'dt-body-nowrap'
    }],

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
            tabela_vencidos.draw();
            limpa_campos('modal-marcar-pago');
          } else {
            erro(data.msg);
          }
        }
      });
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