<!-- MODAL CADASTRA CLIENTE -->
<div class="modal fade" id="modal-cadastra-financeiro">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Cadastrar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModalCadastrarFinanceiro" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" id="codigo_fin" name="codigo_fin" value="0">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-check">
                  <?php $campo = 'tipo_fin'; ?>
                  <input class="form-check-input" type="radio" name="<?= $campo ?>" id="<?= $campo ?>-1" value="1" checked>
                  <label class="form-check-label" for="<?= $campo ?>-1">
                    Despesa
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <?php $campo = 'tipo_fin'; ?>
                  <input class="form-check-input" type="radio" name="<?= $campo ?>" id="<?= $campo ?>-2" value="2">
                  <label class="form-check-label" for="<?= $campo ?>-2">
                    Receita
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'codigo_usu'; ?>
                  <label for="<?= $campo ?>">Vínculo à funcionário? </label>
                  <select class="selectpicker custom-select form-control" id="<?= $campo ?>" name="<?= $campo ?>">
                    <option value="0" selected>Não</option>
                    <?php foreach ($funcionarios as $item) { ?>
                      <option value="<?=$item->codigo_usu?>"><?=$item->nome_usu?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'data_fin'; ?>
                  <label for="<?= $campo ?>">Data: </label>
                  <input type="date" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="DD/MM/YYYY">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'nome_fin'; ?>
                  <label for="<?= $campo ?>">Nome: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Nome">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'valor_fin'; ?>
                  <label for="<?= $campo ?>">Valor: </label>
                  <input type="text" class="form-control money" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="0,00">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'descricao_fin'; ?>
                  <label for="<?= $campo ?>">Descrição: </label>
                  <textarea class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" rows="3"></textarea>
                </div>
              </div>
            </div>
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
</div>