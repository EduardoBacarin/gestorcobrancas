var base_url = $("#base_url").val();
var avisos = "Obrigatório."

$(document).ready(function () {
  $("#tabela-clientes").DataTable({
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

});

$(document).on('click', '#btn-modal-cadastro', function () {
  limpa_campos('formModalCadastrarCliente');
  $('#modal-cadastra-cliente').modal('show');
});


function limpa_campos(form) {
  $('#' + form).trigger("reset");
};