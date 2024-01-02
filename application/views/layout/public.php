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
</head>

<body class="container-fluid">
    <?php if ($view) : $this->load->view($view); endif; ?>

    <script type="text/javascript">
        let key = "<?= hexa('636F6E66')(hexa('7365637265745f6b65795f62616e676574')) ?>";
    </script>
    <!-- jQuery -->
    <script type="text/javascript" src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script async type="text/javascript" src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <?php if (isset($js) && count($js) > 0):
        foreach((array) $js as $j):
            require_once(SCRIPT_PATH . str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $j));
        endforeach;
    endif; ?>
</body>

</html>