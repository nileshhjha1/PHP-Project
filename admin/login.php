<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition login-page bg-navy">
    <script>
    start_loader()
    </script>
    <h2 class="text-center mb-4 pb-3"><?php echo $_settings->info('name') ?></h2>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-body">
            <?php if (isset($_SESSION['message'])) : ?>
                    <div class="alert alert-<?php echo strpos($_SESSION['message'], 'Error') !== false ? 'danger' : 'success'; ?>" role="alert">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <p class="login-box-msg text-dark">Sign in to start your session</p>

                <form id="login-frm" action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Username" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-conten-center">
                        <!-- /.col -->
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        <!-- /.col -->
                    </div>
                    <br>
                    <p class="text-dark">Don't have an account? <a href="register.php">Sign up now</a>.</p>

                </form>
                <!-- /.social-auth-links -->

                <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

    <script>
    $(document).ready(function() {
        end_loader();
    })
    </script>
    <script>
        // Fade out the alert after 5 seconds
        setTimeout(function() {
            $(".alert").fadeOut("slow");
        }, 3000);
    </script>

</body>

</html>