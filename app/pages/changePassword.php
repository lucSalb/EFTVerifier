<?php 
    $PageTitle="Change password";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['updatePasswordForm']))
        {
            $errors=[];
            if(!isset($_POST['OldPassword']))
            {
                $errors['ErrorOldPassword'] = "Insert your current password.";
            }
            if(!isset($_POST['NewPassword']))
            {
                $errors['ErrorNewPassword'] = "New password is a mandatory field.";
            }
            if(!isset($_POST['ConfirmNewPassword']))
            {
                $errors['ErrorCNewPassword'] = "Confirm new password is a mandatory field.";
            }
            //
            if(strlen($_POST['OldPassword']) < 6 || strlen($_POST['OldPassword']) > 12)
            {
                $errors['ErrorPassword'] = "Your current password has from 6 to 12 characters";
            }
            if(strlen($_POST['NewPassword']) < 6 || strlen($_POST['OldPassword']) > 12)
            {
                $errors['NewPassword'] = "Your new password must have from 6 to 12 characters";
            }
            elseif($_POST['NewPassword'] != $_POST['ConfirmNewPassword'])
            {
                $errors['ConfirmNewPassword'] = "Your new password does not match with the confirmed password";
            }
            if(empty($errors))
            {
                $data['Username'] = $_SESSION['Username'];
                $data['HashPassword'] = hash("sha256",$_POST['OldPassword']); 
                $data['NewHashPassword'] = hash("sha256",$_POST['NewPassword']); 

                $result = changePassword($data);
                if(!$result['Success'])
                {
                    $errors['RegisterError'] = $result['Error'];
                }
                else
                {
                    $server_messages['RegisterSuccess'] = $result['Message'];
                    $_POST['OldPassword']="";
                    $_POST['NewPassword']="";
                    $_POST['ConfirmNewPassword']="";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=APP_NAME?> - <?php echo  $PageTitle ?></title>
    <link rel="icon" type="image/x-icon" type="image/ico" href="<?=ROOT?>/img/favicon.ico">

    <!-- Custom fonts for this template-->
    <link href="<?=ROOT?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=ROOT?>/public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?=ROOT?>/public/css/SMStyle.css" rel="stylesheet">

</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- MENU -->
        <?php include("partials/menu.php");?>
        <!-- END OF MENU -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- TOP BAR -->
                <?php include("partials/topBar.php")?>
                <!-- END OF TOP BAR -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $PageTitle; ?></h1>
                    </div>
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-7 mx-auto">
                                    <div class="p-5">
                                        <div class="text-center">
                                        </div>
                                        <form class="user" method="post">
                                            <div class="form-group">
                                                <input type="password" name="OldPassword" class="form-control form-control-user" id="exampleInputEmail"
                                                    placeholder="Old password" value="<?php echo old_value('OldPassword') ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="NewPassword" class="form-control form-control-user" id="exampleInputEmail"
                                                    placeholder="New password" value="<?php echo old_value('NewPassword') ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="ConfirmNewPassword" class="form-control form-control-user" id="exampleInputEmail"
                                                    placeholder="Confirm new password" value="<?php echo old_value('ConfirmNewPassword') ?>">
                                            </div>
                                            <hr>
                                            <Button name="updatePasswordForm" class="btn btn-primary btn-user btn-block">
                                                Change password
                                            </Button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Empirija - <?php echo date("Y") ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- ALERTS -->
    <?php include("partials/alerts.php");?>
    <!-- END ALERTS -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="<?=ROOT?>/public/vendor/jquery/jquery.min.js"></script>
    <script src="<?=ROOT?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=ROOT?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=ROOT?>/public/js/sb-admin-2.min.js"></script>
   
</body>
</html>