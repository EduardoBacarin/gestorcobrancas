  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-4">
            <h1>Financeiro <strong>GC</strong>obrança</h1>
          </div>
          <div class="col-sm-2 d-flex justify-content-end">
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
          <div class="col-sm-2 d-flex justify-content-end">
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
          <div class="col-sm-4">
            <button type="button" class="btn btn-info  float-sm-right" id="btn-modal-cadastro">
              <i class="fas fa-plus"></i> Cadastrar
            </button>
          </div>
          <div class="col-sm-1">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Financeiro</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- GRÁFICOS -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4">
              <div class="card w-100 card-gastoscat">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Gastos por Categoria</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div id="graficocategoria"></div>
                </div>
                <div class="overlay dark">
                  <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card w-100 card-gastosfunc">
                <div class="card-header border-0">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Gastos por Funcionário</h3>
                  </div>
                </div>
                <div class="card-body">
                  <div id="graficofuncionario"></div>
                </div>
                <div class="overlay dark">
                  <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="card w-100 card-resumo">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>Despesas</h4>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <h5 id="total_despesas" class="ml-2">R$0,00</h5>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <hr>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <h4>Receitas</h4>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <h5 id="total_receita" class="ml-2">R$0,00</h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="overlay dark">
                  <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Despesas</h3>
              </div>
              <div class="card-body">
                <table id="tabela-despesas" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                  <thead>
                    <th>#</th>
                    <th>Data</th>
                    <th>Funcionário</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Receitas</h3>
              </div>
              <div class="card-body">
                <table id="tabela-receitas" class="table table-bordered table-hover dataTable dtr-inline collapsed">
                  <thead>
                    <th>#</th>
                    <th>Data</th>
                    <th>Funcionário</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Ações</th>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

      <input type="hidden" id="mes_selecionado" value="<?= date('m') ?>">
      <input type="hidden" id="ano_selecionado" value="<?= date('Y') ?>">
    </section>
  </div>