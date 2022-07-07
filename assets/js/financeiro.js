var base_url = $("#base_url").val();
var avisos = "Obrigatório."
var tabela_despesas, tabela_receitas;
var mes_selecionado = $('#mes_selecionado').val();
var ano_selecionado = $('#ano_selecionado').val();

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
    "ajax": {
      url: base_url + "financeiro/listar_despesas",
      'data': function (data) {
        data.mes_selecionado = mes_selecionado;
        data.ano_selecionado = ano_selecionado;
      }
    },
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
    "ajax": {
      url: base_url + "financeiro/listar_receitas",
      'data': function (data) {
        data.mes_selecionado = mes_selecionado;
        data.ano_selecionado = ano_selecionado;
      }
    },
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
            calcula_resumo(mes_selecionado, ano_selecionado);
          } else {
            erro(data.msg);
          }
        }
      });
    });

  grafico_categoria();
  grafico_funcionario();
  calcula_resumo(mes_selecionado, ano_selecionado);
});

$(document).on('change', '#troca-mes', function () {
  $('#mes_selecionado').val($(this).find(':selected').val());
  mes_selecionado = $(this).find(':selected').val();
  tabela_despesas.draw();
  tabela_receitas.draw();
  calcula_resumo(mes_selecionado, ano_selecionado);
});

$(document).on('change', '#troca-ano', function () {
  $('#ano_selecionado').val($(this).find(':selected').val());
  ano_selecionado = $(this).find(':selected').val();
  tabela_despesas.draw();
  tabela_receitas.draw();
  calcula_resumo(mes_selecionado, ano_selecionado);
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
        if (data.dados.tipo_fin == 1) {
          $("#tipo_fin-1").prop("checked", true);
        } else {
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

function grafico_categoria() {

  $.ajax({
    url: base_url + 'financeiro/grafico_despesas_categoria',
    type: 'POST',
    dataType: 'json',
    success: function (data) {
      if (data.retorno) {
        monta_grafico_categoria(data.soma, data.categoria);
      } else {
        erro('Não foi possível montar o gráfico');
      }
    },
    error: function () {

    }
  });
}

function grafico_funcionario() {

  $.ajax({
    url: base_url + 'financeiro/grafico_despesas_funcionario',
    type: 'POST',
    dataType: 'json',
    success: function (data) {
      if (data.retorno) {
        monta_grafico_funcionario(data.soma, data.funcionario);
      } else {
        erro('Não foi possível montar o gráfico');
      }
    },
    error: function () {

    }
  });
}

function monta_grafico_categoria(valor, categoria) {
  var options = {
    chart: {
      type: 'donut'
    },
    series: valor,
    labels: categoria,
    width: '100%',
    tooltip: {
      x: {
        show: false
      },
      y: {
        formatter: function (value) {
          return value.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
        }
      }
    },
    legend: {
      position: 'bottom'
    },
  }

  var grafcategoria = new ApexCharts(document.querySelector("#graficocategoria"), options);
  grafcategoria.render();
  $('.card-gastoscat').find('.overlay').hide();
}


function monta_grafico_funcionario(valor, funcionario) {
  var options = {
    chart: {
      type: 'donut'
    },
    series: valor,
    labels: funcionario,
    width: '100%',
    tooltip: {
      x: {
        show: false
      },
      y: {
        formatter: function (value) {
          return value.toLocaleString('pt-br', { style: 'currency', currency: 'BRL' });
        }
      }
    },
    legend: {
      position: 'bottom'
    },
  }

  var graffuncionario = new ApexCharts(document.querySelector("#graficofuncionario"), options);
  graffuncionario.render();
  $('.card-gastosfunc').find('.overlay').hide();
}

function calcula_resumo(mes, ano) {
  $('.card-resumo').find('.overlay').show();
  $.ajax({
    url: base_url + 'financeiro/calcula_resumo',
    type: 'POST',
    data: { mes: mes, ano: ano },
    dataType: 'json',
    success: function (data) {
      if (data.retorno) {
        $('#total_receita').html(parseFloat(data.receita).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
        $('#total_despesas').html(parseFloat(data.despesa).toLocaleString('pt-br', { style: 'currency', currency: 'BRL' }));
      } else {
        $('#total_receita').html('R$ 0,00');
        $('#total_despesas').html('R$ 0,00');
        $('.card-resumo').find('.overlay').hide();
        // erro('Erro ao fazer a busca do resumo!');
      }
      $('.card-resumo').find('.overlay').hide();
    },
    error: function () {
      $('#total_receita').html('R$ 0,00');
      $('#total_despesas').html('R$ 0,00');
      $('.card-resumo').find('.overlay').hide();
      erro('Erro ao fazer a busca do resumo!');
    }
  });
}