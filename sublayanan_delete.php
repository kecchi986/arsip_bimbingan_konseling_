<?php
require 'functions.php';
require_login();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    redirect('layanan.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Sublayanan - <?php echo $app_name; ?></title>
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <div class="account-pages my-5 pt-sm-0">
        <div class="container">
            <!-- end row -->
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary"> Delete Sublayanan</h5>
                                        <p class="text-muted">Delete Sublayanan.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <div class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-user-circle text-primary"></i>
                                        </span>
                                    </div>
                                </div>
                                <a href="index.php" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-user-circle text-primary"></i>
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" action="" method="post">
                                    <div class="form-group">
                                        <label for="sublayanan_id">Sublayanan ID</label>
                                        <input type="text" class="form-control" id="sublayanan_id" name="sublayanan_id" required>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary w-md waves-effect waves-light">Delete Sublayanan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
</body>
</html> 