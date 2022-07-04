  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Financeiro <strong>GC</strong>obrança</h1>
          </div>
          <div class="col-sm-5">
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

        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>