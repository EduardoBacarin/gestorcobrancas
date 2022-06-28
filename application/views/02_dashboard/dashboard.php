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
              <h3><?=$pagam_hoje?></h3>

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
              <h3><?=$atrasados?></h3>

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
    <!-- /.content -->
  </div>