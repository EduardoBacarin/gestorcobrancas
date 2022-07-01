<!-- MODAL CADASTRA CLIENTE -->
<div class="modal fade" id="modal-cadastra-funcionario">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Cadastrar Funcionário</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModalCadastrarFuncionario" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" id="codigo_usu" name="codigo_usu" value="0">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'nome_func'; ?>
                  <label for="<?= $campo ?>">Nome: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Nome" maxlength="100">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'documento_func'; ?>
                  <label for="<?= $campo ?>">Documento: </label>
                  <input type="text" class="form-control cpfcnpj" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Documento">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'telefone_func'; ?>
                  <label for="<?= $campo ?>">Telefone: </label>
                  <input type="text" class="form-control celular" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Telefone">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <?php $campo = 'email_func'; ?>
                  <label for="<?= $campo ?>">E-Mail: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="E-Mail" maxlength="40">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <?php $campo = 'senha_func'; ?>
                  <label for="<?= $campo ?>">Senha de Acesso: </label>
                  <input type="text" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="Senha de Acesso" maxlength="12">
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