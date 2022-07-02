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
              <?php if ($this->session->userdata('usuario')['nivel_usu'] == 1) { ?>
              <div class="col-md-4  d-flex justify-content-end">
                <button type="button" class="btn btn-info" id="btn-modal-cadastro">
                  <i class="fas fa-plus"></i> Cadastrar
                </button>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="card-body">
          <input type="hidden" id="mes_selecionado" value="<?= date('m') ?>">
          <input type="hidden" id="ano_selecionado" value="<?= date('Y') ?>">
          <input type="hidden" id="codigo_cob" value="0">
          <table id="tabela-cobrancas" class="table table-bordered table-hover dataTable dtr-inline">
            <thead>
              <th>#</th>
              <th>Cliente</th>
              <th>Cidade / UF</th>
              <th>Parcelas</th>
              <th>Taxa</th>
              <th>Tipo</th>
              <th>Total com Juros</th>
              <th>Emprestado</th>
              <th>Lucro</th>
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