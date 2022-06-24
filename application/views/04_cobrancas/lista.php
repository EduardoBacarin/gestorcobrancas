  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cobranças <strong>GC</strong>obrança</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Cobranças</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Todas as Cobranças</h3>

          <div class="card-tools" style="width: 40%;">
            <div class="row">
              <div class="col-md-4 d-flex justify-content-end">
                <select class="selectpicker form-control" id="troca-ano" name="troca-ano">
                  <?php
                  for ($i = 0; $i < 10; $i++) {
                    $ano = 2022 + $i;
                    $selected = $mes[1] == date('Y') ? 'selected' : '';
                    echo '<option value="' . $ano . '" ' . $selected . '>' . $ano . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4 d-flex justify-content-end">
                <select class="selectpicker form-control" id="troca-mes" name="troca-mes">
                  <?php
                  for ($i = 1; $i < 12; $i++) {
                    $mes = meses($i);
                    $selected = $mes[1] == date('m') ? 'selected' : '';
                    echo '<option value="' . $mes[1] . '" ' . $selected . '>' . $mes[0] . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-4  d-flex justify-content-end">
                <button type="button" class="btn btn-info" id="btn-modal-cadastro">
                  <i class="fas fa-plus"></i> Cadastrar
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <input type="hidden" id="mes_selecionado" value="<?= date('m') ?>">
          <input type="hidden" id="ano_selecionado" value="<?= date('Y') ?>">
          <table id="tabela-cobrancas" class="table table-bordered table-hover dataTable dtr-inline">
            <thead>
              <th>#</th>
              <th>Cliente</th>
              <th>Valor Negociado</th>
              <th>Valor Parcela</th>
              <th>Restante</th>
              <th>Prazo</th>
              <th>Status</th>
              <th>Taxa</th>
              <th>Lucro Parcela</th>
              <th>Ações</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

  <!-- MODAL MARCA PAGO -->
  <div class="modal fade" id="modal-marcar-pago">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-sucess">
          <h4 class="modal-title">Marcar Pago</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formModalMarcarPago" novalidate="novalidate" enctype="multipart/form-data">
            <input type="hidden" id="codigo_par" name="codigo_par" value="0">
            <input type="hidden" id="datalimite_par" name="datalimite_par" value="0">
            <input type="hidden" id="valororiginal" name="valororiginal" value="0">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <?php $campo = 'datapago_par'; ?>
                    <label for="<?= $campo ?>">Data do Pagamento: </label>
                    <input type="date" class="form-control" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="DD/MM/YYYY">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <?php $campo = 'valorpago_par'; ?>
                    <label for="<?= $campo ?>">Valor do Pagamento: </label>
                    <div class="input-group mb-2">
                      <div class="input-group-prepend">
                        <div class="input-group-text">R$</div>
                      </div>
                      <input type="text" class="form-control money" id="<?= $campo ?>" name="<?= $campo ?>" placeholder="0,00">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Marcar Pago</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>