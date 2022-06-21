<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GCobranças | Login</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/formValidation/formValidation.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <!-- <a href="#" class="h1"><b>SG</b>Equinos</a> -->
      <img src="<?= base_url('assets/svg/logo_full.svg')?>" style="width: 80%;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Cadastre-se para acessar nossos serviços</p>

      <form id="FormLogin" method="post" novalidate="novalidate" enctype="multipart/form-data" class="form-group">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email_user" id="email_user">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="senha_user" id="senha_user">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
          </div>
        </div>
      </form>
      <p class="mb-0">
        <!-- <a href="<?php echo base_url('login/registro') ?>" class="text-center">Cadastrar-se</a> -->
      </p>
    </div>
  </div>
</div>

</body>
<input type="hidden" id="base_url" value="<?php echo base_url() ?>">

<script src="<?php echo base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/formValidation.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/framework/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/language/pt_BR.min.js"></script>
<script src="<?php echo base_url('assets') ?>/js/adminlte.min.js"></script>
<script src="<?php echo base_url('assets') ?>/js/login.js"></script>
<script src="<?php echo base_url('assets') ?>/js/funcoes.js"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
</html>
