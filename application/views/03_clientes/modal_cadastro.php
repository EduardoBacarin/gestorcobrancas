<!-- MODAL CADASTRA CLIENTE -->
<div class="modal fade" id="modal-cadastra-cliente">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Cadastrar Cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formModalCadastrarCliente" novalidate="novalidate" enctype="multipart/form-data">
          <input type="hidden" id="codigo_cli" name="codigo_ant" value="0">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="nome_ant">Nome: </label>
                  <input type="text" class="form-control" id="nome_ant" name="nome_ant" placeholder="Nome Comercial">
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