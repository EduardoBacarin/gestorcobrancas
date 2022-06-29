  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard <strong>GC</strong>obrança</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php if ($this->session->userdata('usuario')['nivel_usu'] == 1) { ?>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $cobrancas ?></h3>

                  <p>Cobranças</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>R$ <?= $lucro ?></h3>

                  <p>Lucro Total</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?= $pagam_hoje ?></h3>

                  <p>A pagar hoje</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?= $atrasados ?></h3>

                  <p>Atrasados</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?= $cobrancas_mes ?></h3>

                  <p>Cobranças este mês</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>R$ <?= $lucro_mes ?></h3>

                  <p>Lucro este mês</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
              </div>
            </div>
            <!-- ./col -->
          </div>

      </section>
    <?php } ?>
    <section class="content">
      <div class="container-fluid">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Atrasados</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <table id="tabela-vencidos" class="table table-bordered table-hover dataTable dtr-inline" style="width: 100%">
                  <thead>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Emprestado</th>
                    <th>Valor da Parcela</th>
                    <th>Parcela</th>
                    <th>Data de Vencimento</th>
                    <th>Lucro</th>
                    <th>Ações</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
                <!-- /.content -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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


  <!-- MODAL CALCULA JUROS -->
  <div class="modal fade" id="modal-calcula-juros">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-sucess">
          <h4 class="modal-title">Cálculo de Juros</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <h4><strong>Tipo de Juros:</strong></h4>
                <span class="juros" id="tipodejuros_parcela"></span>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>Taxa de Juros:</strong></h4>
                <span class="juros" id="taxadejuros_parcela"></span>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>Valor Original da Parcela:</strong></h4>
                <span class="juros" id="valororiginal_parcela"></span>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>Valor da Parcela com Juros:</strong></h4>
                <span class="juros" id="valorcomjuros_parcela"></span>
                <hr>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>Dias Atrasados:</strong></h4>
                <span class="juros" id="diasatrasados_parcela"></span>
                <hr>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>