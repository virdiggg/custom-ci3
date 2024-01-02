<script type="text/javascript">
    let key = "<?= hexa('636F6E66')(hexa('7365637265745f6b65795f62616e676574')) ?>";
</script>
<!-- jQuery -->
<script type="text/javascript" src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- Bootstrap 4 -->
<script async type="text/javascript" src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- AdminLTE App -->
<script async type="text/javascript" src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
<!-- Select2 -->
<script type="text/javascript" src="<?= base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- Sweetalert2 -->
<script type="text/javascript" src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
<!-- Datatables -->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<!-- Datatables BS4 -->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<?php if (isset($js) && count($js) > 0):
    foreach((array) $js as $j):
        require_once(SCRIPT_PATH . str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $j));
    endforeach;
endif; ?>
</body>
</html>