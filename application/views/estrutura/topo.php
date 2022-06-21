<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GCobrança</title>
  <link rel="icon" href="<?= base_url('assets') ?>/imagens/favicon.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css"> -->
  <script src="https://kit.fontawesome.com/f89139718b.js" crossorigin="anonymous"></script>
  <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/fabric.js/1.4.0/fabric.min.js'></script>
  <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/formValidation/formValidation.min.css"> -->
  <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/balloon/balloon.css">
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/adminlte.css">
  <link rel="stylesheet" href="<?= base_url('assets') ?>/css/estilo.css">
  <?php

  if (!empty($css_link)) {
    foreach ($css_link as $cada) {
      echo '<link href="' . $cada . '" rel="stylesheet"></script>';
    }
  }

  if (!empty($css)) {
    foreach ($css as $cada) {
      echo '<link href="' . base_url($cada) . '" rel="stylesheet">';
    }
  }

  ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <input type="hidden" id="base_url" value="<?= base_url() ?>">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link collapse-nav" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= base_url('dashboard') ?>" class="nav-link">Dashboard</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('usuario') ?>" role="button">
            <i class="fa-solid fa-user mr-2"></i>
            <?= $this->session->userdata('usuario')['nome_usu']; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('login/sair') ?>" role="button">
            <i class="fa-solid fa-right-from-bracket"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= base_url('dashboard') ?>" class="brand-link logo-switch">
        <img src="<?= base_url('assets/svg/logo_minimal.svg') ?>" alt="GCobrança" class="brand-image-xl logo-xs svg-branco" style="left: 5px;">
        <img src="<?= base_url('assets/svg/logo_full.svg') ?>" alt="GCobrança" class="brand-image-xs logo-xl svg-branco" style="left: 50px; top: 7px;">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?= base_url('dashboard') ?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('cliente') ?>" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Clientes
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>