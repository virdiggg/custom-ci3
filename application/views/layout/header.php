<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Cache-Control" content="max-age=86400" />
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>

    <link rel="icon" href="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" />
    <link rel="apple-touch-icon" href="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" />
    <link rel="manifest" href="<?= base_url('manifest.json') ?>" />

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css') ?>" />
    <!-- Font Awesome -->
    <link rel="preload" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript>
        <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>" />
    </noscript>
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2/css/select2.min.css'); ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'); ?>" />
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.min.css'); ?>" />
    <!-- Datatables BS4 -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>" />
    <!-- Custom CSS -->
    <link rel="preload" href="<?= base_url('assets/dist/css/custom.css'); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript>
        <link rel="stylesheet" href="<?= base_url('assets/dist/css/custom.css'); ?>" />
    </noscript>
    <?php if (isset($css) && count($css) > 0):
        foreach((array) $css as $c): ?>
            <link rel="stylesheet" href="<?= base_url('assets/' . $c) ?>" />
        <?php endforeach;
    endif; ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">