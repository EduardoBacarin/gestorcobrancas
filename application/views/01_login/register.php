<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GCobrança | Registrar</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/formValidation/formValidation.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets')?>/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img src="<?= base_url('assets/svg/logo_full.svg')?>" style="width: 80%;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Register a new membership</p>

      <form id="FormCadastroUsuario" method="post" novalidate="novalidate" enctype="multipart/form-data">
        
      <div class="input-group mb-3">
        <div class="input-group-append col-md-12">
          <div class="form-check col-md-8">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_usuario" value="1" checked><strong>Veterinário</strong>
            </label>
          </div>
          <div class="form-check col-md-8">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="tipo_usuario" value="2"><strong>Laboratório</strong>
            </label>
          </div>
        </div>
      </div>
        
      <div class="input-group mb-3">
          <?php $campo = "nome_user" ?>
          <input type="text" class="form-control" placeholder="Nome do Veterinário ou do Laboratório" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "email_user" ?>
          <input type="text" class="form-control" placeholder="Email" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "telefone_user" ?>
          <input type="text" class="form-control" placeholder="Telefone" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div id="dados_laboratorio"  style="display: none;">
          <div class="input-group mb-3">
            <?php $campo = "credenciais_user" ?>
            <input type="text" class="form-control" placeholder="CRMV ou Portaria de Credenciamento" id="<?= $campo ?>" name="<?= $campo ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "documento_user" ?>
          <input type="text" class="form-control" placeholder="CPF/CNPJ" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?php $campo = "cep_user" ?>
          <input type="text" class="form-control" placeholder="CEP" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "rua_user" ?>
          <input type="text" class="form-control" placeholder="Rua" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "bairro_user" ?>
          <input type="text" class="form-control" placeholder="Bairro" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "numero_user" ?>
          <input type="text" class="form-control" placeholder="Número" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "cidade_user" ?>
          <input type="text" class="form-control" placeholder="Cidade" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "estadouf_user" ?>
          <input type="text" class="form-control" placeholder="Estado (UF)" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "senha_user" ?>
          <input type="password" class="form-control" placeholder="Password" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <?php $campo = "redigitasenha_user" ?>
          <input type="password" class="form-control" placeholder="Retype password" id="<?= $campo ?>" name="<?= $campo ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
          </div>
        </div>
      </form>
      <a href="<?= base_url('login') ?>" class="text-center">Eu já tenho uma conta</a>
    </div>
  </div>
</div>

<input type="hidden" id="base_url" value="<?= base_url() ?>">

<script src="<?php echo base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/formValidation.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/framework/bootstrap.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/formValidation/language/pt_BR.min.js"></script>
<script src="<?php echo base_url('assets') ?>/js/adminlte.min.js"></script>
<script src="<?php echo base_url('assets') ?>/js/register.js"></script>
</body>
</html>
