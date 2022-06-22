<!-- MODAL CADASTRA CLIENTE -->
<div class="modal fade" id="modal-cadastra-cobranca">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Cadastrar Cobrança</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModalCadastrarCobranca" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" id="codigo_cli" name="codigo_cli" value="0">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <?php $campo = 'nome_cli'; ?>
                  <label for="<?= $campo ?>">Cliente: </label>
                  <select class="selectpicker custom-select form-control" id="<?= $campo ?>" name="<?= $campo ?>" data-live-search="true">
                    <option value="" selected>Selecione um Cliente</option>
                    <?php foreach ($clientes as $cli) { ?>
                      <option value="<?= $cli->codigo_cli ?>" data-doc="<?= $cli->documento_cli ?>" data-tel="<?= $cli->telefone_cli ?>"><?= $cli->nome_cli ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php $campo = 'documento_cli'; ?>
                  <label for="<?= $campo ?>">Documento do Cliente: </label>
                  <input type="text" class="form-control cpfcnpj" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Documento do Cliente" disabled>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <?php $campo = 'telefone_cli'; ?>
                  <label for="<?= $campo ?>">Telefone do Cliente: </label>
                  <input type="text" class="form-control celular" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Telefone do Cliente" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-1">
                <div class="form-group">
                  <?php $campo = 'qtdparcelas_cob'; ?>
                  <label for="<?= $campo ?>">Parcelas: </label>
                  <input type="number" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" max="36" min="1" value="1">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <?php $campo = 'total_cob'; ?>
                  <label for="<?= $campo ?>">Valor da Dívida: </label>
                  <input type="text" class="form-control money" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="0,00">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <?php $campo = 'tipojuros_cob'; ?>
                  <label for="<?= $campo ?>">Tipo de Juros: </label>
                  <select class="selectpicker custom-select form-control" id="<?= $campo ?>" name="<?= $campo ?>">
                    <option value="1" selected>Juros Simples</option>
                    <option value="2">Juros Composto</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <?php $campo = 'diacobranca_cob'; ?>
                  <label for="<?= $campo ?>">Dia de Cobrança: </label>
                  <input type="number" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" max="28" min="1" value="1" data-toggle="tooltip" data-placement="top" title="Dia combinado para o pagamento">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <?php $campo = 'dialimite_cob'; ?>
                  <label for="<?= $campo ?>">Dia Limite: </label>
                  <input type="number" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" max="28" min="1" value="1" data-toggle="tooltip" data-placement="top" title="Dia final para pagamento, juros correrá a partir deste dia">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <?php $campo = 'juros_cob'; ?>
                  <label for="<?= $campo ?>">Taxa de Juros: </label>
                  <input type="text" class="form-control percent" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="0,00%">
                </div>
              </div>
            </div>
            <div class="row">
              <hr style="width: 40%">
              <h3>Projeção</h3>
              <hr style="width: 40%">
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <div class="d-flex justify-content-center">
                  <h5>Total da Dívida</h5>
                </div>
                <div class="d-flex justify-content-center">
                  <span id="totaldivida">R$0,00</span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex justify-content-center">
                  <h5>Total c/ Juros</h5>
                </div>
                <div class="d-flex justify-content-center">
                  <span id="txttotaljuros">R$0,00</span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex justify-content-center">
                  <h5>Valor da Parcela</h5>
                </div>
                <div class="d-flex justify-content-center">
                  <span id="txtparcela">R$0,00</span>
                </div>
              </div>
              <div class="col-md-3">
                <div class="d-flex justify-content-center">
                  <h5>Lucro</h5>
                </div>
                <div class="d-flex justify-content-center">
                  <span id="txtlucro">R$0,00</span>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" id="totalcomjuros" name="totalcomjuros" value="0">
          <input type="hidden" id="valorparcela" name="valorparcela" value="0">
          <input type="hidden" id="valorlucro" name="valorlucro" value="0">
          <input type="hidden" id="jurosaodia" name="jurosaodia" value="0">
          <div class="row">
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>