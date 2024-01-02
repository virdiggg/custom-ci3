<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php require_once(VIEW_PATH . 'title.php'); ?>
    <!-- Main content -->
    <section class="content">
        <?php if ($view): $this->load->view($view); endif; ?>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->