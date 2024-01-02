<?php

$this->load->helper('arr');
$this->load->library('authenticated');
$this->authenticated->checkAuth();

$tempRes = $this->navs->get();
$res = keyBy($tempRes, 'is_top_nav', true);
$navs = parseChildrenAlt($res['N'], 'id', 'parent_id', 'childrens');
$topNav = $res['Y'];

require_once(VIEW_PATH . 'header.php');
require_once(VIEW_PATH . 'head.php');
require_once(VIEW_PATH . 'sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php require_once(VIEW_PATH . 'title.php'); ?>
    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="<?= base_url('dashboard') ?>">return to dashboard</a>.
                </p>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
require_once(VIEW_PATH . 'foot.php');
require_once(VIEW_PATH . 'footer.php');
