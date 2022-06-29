<!-- MODAL CADASTRA CLIENTE -->
<div class="modal fade" id="modal-cadastra-cliente">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Cadastrar Cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModalCadastrarCliente" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" id="codigo_cli" name="codigo_cli" value="0">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'nome_cli'; ?>
                  <label for="<?= $campo ?>">Nome: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Nome">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'documento_cli'; ?>
                  <label for="<?= $campo ?>">Documento: </label>
                  <input type="text" class="form-control cpfcnpj" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Documento">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'telefone_cli'; ?>
                  <label for="<?= $campo ?>">Telefone: </label>
                  <input type="text" class="form-control celular" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Telefone">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'email_cli'; ?>
                  <label for="<?= $campo ?>">E-Mail: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="E-Mail">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <?php $campo = 'cep_cli'; ?>
                  <label for="<?= $campo ?>">CEP: </label>
                  <input type="text" class="form-control cep" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="CEP">
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <?php $campo = 'endereco_cli'; ?>
                  <label for="<?= $campo ?>">Logradouro: </label>
                  <input type="text" class="form-control logradouro" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Logradouro">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <?php $campo = 'numero_cli'; ?>
                  <label for="<?= $campo ?>">Número: </label>
                  <input type="text" class="form-control numero" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Número">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'bairro_cli'; ?>
                  <label for="<?= $campo ?>">Bairro: </label>
                  <input type="text" class="form-control bairro" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Bairro">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'complemento_cli'; ?>
                  <label for="<?= $campo ?>">Complemento: </label>
                  <input type="text" class="form-control bairro" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Complemento">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'cidade_cli'; ?>
                  <label for="<?= $campo ?>">Cidade: </label>
                  <input type="text" class="form-control cidade" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Cidade">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'estado_cli'; ?>
                  <label for="<?= $campo ?>">Estado: </label>
                  <input type="text" class="form-control estado" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Estado">
                </div>
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