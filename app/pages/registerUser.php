<?php 
    $PageTitle="Register user";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['RegisterUserForm']))
        {
            $errors=[];
            if(!isset($_POST['Name']))
            {
                $errors['ErrorName'] = "Name is a mandatory field.";
            }
            if(!isset($_POST['Username']))
            {
                $errors['ErrorUsername'] = "Username is a mandatory field.";
            }
            else
            {
                $result = validateUsername($_POST['Username']);
                if(!$result['Success'])
                {
                    $errors['searchError'] = $result['Error'];
                }
                else
                {
                    if(!$result['Structure']) $errors['ErrorUsernameTaken'] = "Username is already registered.";
                }
            }
            if(!isset($_POST['Email']))
            {
                $errors['ErrorEmail'] = "E-mail is a mandatory field.";
            }
            else
            {
                $result = validateEmail($_POST['Email']);
                if(!$result['Success'])
                {
                    $errors['searchEmailError'] = $result['Error'];
                }
                else
                {
                    if(!$result['Structure']) $errors['ErrorEmailTaken'] = "Inserted E-mail is already registered.";
                }
            }
            if(!isset($_POST['Password']))
            {
                $errors['ErrorPassword'] = "Password is a mandatory field.";
            }
            elseif(strlen($_POST['Password']) < 6 || strlen($_POST['Password']) > 12)
            {
                $errors['ErrorPassword'] = "Password must have from 6 to 12 characters";
            }
            if(!isset($_POST['ConfirmPassword']))
            {
                $errors['ErrorConfirmPassword'] = "Confirm password.";
            }
            elseif($_POST['ConfirmPassword'] != $_POST['Password'])
            {
                $errors['ErrorConfirmPassword'] = "Password and confirm password don`t match.";
            }
            if(empty($errors))
            {
              
                $data['Name'] = $_POST['Name'];
                $data['Username'] = $_POST['Username'];
                $data['Email'] = $_POST['Email'];
                $data['HashPassword'] = hash("sha256",$_POST['Password']); 
                $result = registerUser($data);
                if(!$result['Success'])
                {
                    $errors['RegisterError'] = $result['Error'];
                }
                else
                {
                    $server_messages['RegisterSuccess'] = $result['Message'];
                    $_POST['Name']="";
                    $_POST['Username']="";
                    $_POST['Email']="";
                    $_POST['Password']="";
                    $_POST['ConfirmPassword']="";
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

    <title><?=APP_NAME?>- <?php echo  $PageTitle ?></title>
    <link rel="icon" type="image/x-icon" type="image/ico" href="<?=ROOT?>/public/img/favicon.ico">

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
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user" name="Name" id="Name"
                                                        placeholder="Name" value="<?php echo old_value('Name') ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-user" name="Username" id="Username"
                                                        placeholder="Username" value="<?php echo old_value('Username') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="Email" class="form-control form-control-user" id="exampleInputEmail"
                                                    placeholder="Email Address" value="<?php echo old_value('Email') ?>">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="Password" name="Password" placeholder="Password" value="<?php echo old_value('Password') ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="ConfirmPassword" name="ConfirmPassword" placeholder="Repeat Password" value="<?php echo old_value('ConfirmPassword') ?>">
                                                </div>
                                            </div>
                                            <hr>
                                            <Button name="RegisterUserForm" class="btn btn-primary btn-user btn-block">
                                                Register user
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