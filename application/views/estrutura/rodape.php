<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2022-2023 <a href="https://gcobranca.com.br">GCobranca.com.br</a></strong>. Todos os direitos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/plugins/jquery-mask/dist/jquery.mask.min.js') ?>"></script>
<script src="<?= base_url('assets') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets') ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url('assets') ?>/js/adminlte.min.js"></script>
<script src="<?= base_url('assets') ?>/js/mascaras.js"></script>
<script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/plugins/formValidation/formValidation.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/toastr/toastr.min.js') ?>"></script>
<script src="<?= base_url('assets/js/funcoes.js') ?>"></script>
<script src="<?= base_url('assets/plugins/formValidation/framework/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/jquery.countdown-2.1.0/jquery.countdown.js') ?>"></script>
<script src="<?= base_url('assets/plugins/momentjs/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/momentjs/moment-with-locales.min.js') ?>"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>


<?php
if (!empty($js_link)) {
  foreach ($js_link as $cada) {
    echo '<script src="' . $cada . '" ></script>';
  }
}

if (!empty($js)) {
  foreach ($js as $cada) {
    echo '<script src="' . base_url($cada) . '" ></script>';
  }
}
?>
</body>

</html>