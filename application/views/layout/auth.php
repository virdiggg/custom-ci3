<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Cache-Control" content="max-age=86400" />
    <title><?= isset($title) ? $title : 'Login Page' ?></title>

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

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?= base_url('home') ?>" class="h1"><b><?= hexa('636F6E66')('app_name_min') ?></b></a>
            </div>
            <div class="card-body">
                <?php if (!$this->authenticated->authenticated()): ?>
                <p class="login-box-msg">Sign in to start your session</p>
                <p class="login-box-msg" id="message"></p>

                <form method="POST" id="form-authentication">
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required />
                        <span class="input-group-append">
                            <button type="button" class="btn btn-info" id="btn-send">
                                <span class="fas fa-envelope"></span> Check
                            </button>
                        </span>
                    </div>
                    <div class="input-group input-group-sm mb-3" id="input-token"></div>
                    <div class="row" id="btn-submit"></div>
                </form>
                <?php else: ?>
                    <label>Go to</label> <a href="<?= base_url('dashboard') ?>" class="btn btn-block btn-outline-primary">Dashboard</a>
                <?php endif; ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script type="text/javascript" src="<?= base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script async type="text/javascript" src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script async type="text/javascript" src="<?= base_url('assets/dist/js/adminlte.min.js') ?>"></script>
    <script type="text/javascript">
        let key = "<?= hexa('636F6E66')(hexa('7365637265745f6b65795f62616e676574')) ?>";

        btnSubmit = () => {
            return `<button type="submit" class="btn btn-primary btn-block" id="btn-auth">Sign In</button>`;
        }
        inputToken = () => {
            return `<input type="password" name="token" id="token" class="form-control" placeholder="Token" required />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>`;
        }

        $(document).ready(function () {
            $('#btn-send').click(function(e) {
                e.preventDefault();

                let username = $('#username').val();
                let postData = new FormData();
                postData.append('username', username);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('api/auth/check-username') ?>",
                    data: postData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    headers: {
                        'Secret-Key': key
                    },
                    beforeSend: function() {
                        $('#btn-send').html('<i id="spinn" class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"> LOADING...</span>')
                        $('#btn-send').attr('disabled', '');
                        $('.form-control').attr('disabled', '');
                        $('#message').html('');
                    },
                    success: function(response) {
                        $('.form-control').removeAttr('disabled');
                        $('#btn-send').removeAttr('disabled');
                        $('#btn-send').html('<span class="fas fa-envelope"></span> Resend');
                        if (response.status) {
                            $('#input-token').html(inputToken());
                            $('#btn-submit').html(btnSubmit());
                            $('#message').html('<label class="text-success">Auth Token Sent</label>');
                        } else {
                            $('#input-token').html('');
                            $('#btn-submit').html('');
                            $('#message').html(`<label class="text-danger">${response.message}</label>`);
                        }
                    },
                    error: function (response) {
                        $('.form-control').removeAttr('disabled');
                        $('#btn-send').removeAttr('disabled');
                        $('#btn-send').html('<span class="fas fa-envelope"></span> Check');
                        $('#input-token').html('');
                        $('#btn-submit').html('');

                        let data = JSON.parse(response.responseText);
                        $('#message').html(`<label class="text-danger">${data.message}</label>`);
                    }
                });
            });

            $('#form-authentication').submit(function (e) {
                e.preventDefault();

                let username = $('#username').val();
                let token = $('#token').val();
                let postData = new FormData(this);
                postData.append('username', username);
                postData.append('token', token);

                $.ajax({
                    type: "POST",
                    url: "<?= base_url('api/auth/authenticate') ?>",
                    data: postData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "JSON",
                    headers: {
                        'Secret-Key': key
                    },
                    beforeSend: function () {
                        $('#btn-auth').html('<i id="spinn" class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only"> LOADING...</span>')
                        $('#btn-auth').attr('disabled', '');
                        $('#btn-send').attr('disabled', '');
                        $('.form-control').attr('disabled', '');
                        $('#message').html('');
                    },
                    success: function (response) {
                        if (response.status === false) {
                            $('#btn-auth').removeAttr('disabled');
                            $('#btn-send').removeAttr('disabled');
                            $('.form-control').removeAttr('disabled');
                            $('#btn-auth').html('Sign In');

                            $('#input-token').html('');
                            $('#btn-submit').html('');
                        }

                        $('#message').html(`<label class="text-success">Redirecting...</label>`);

                        setTimeout(function() {
                            window.location.href = response.url;
                        }, 1000);
                    },
                    error: function (response) {
                        $('#btn-auth').removeAttr('disabled');
                        $('#btn-send').removeAttr('disabled');
                        $('.form-control').removeAttr('disabled');
                        $('#btn-auth').html('Sign In');
                        $('#input-token').html('');
                        $('#btn-submit').html('');

                        let data = JSON.parse(response.responseText);
                        $('#message').html(`<label class="text-danger">${data.message}</label>`);
                    }
                });
            });
        });
    </script>
</body>

</html>