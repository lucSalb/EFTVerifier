<?php 
    $PageTitle = "Login";
    if(isset($_SESSION['Username']) && isset($_SESSION['Name']) && isset($_SESSION['Id']) && isset($_SESSION['Email'])) 
    {
        redirect(ROOT."/Home");
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['submitLoginForm']))
        {
            if(empty($_POST['Username']))
            {
                $errors['Username'] = "Username is required";
            }
            elseif(strstr($_POST['Username'],' '))
            {
                $errors['Username'] = "Username has no empty spaces.";
            }
            if(empty($_POST['Password']))
            {
                $errors['Password'] = "Password is required";
            }
            elseif(strlen($_POST['Password']) < 6)
            {
                $errors['Password'] = "Password is at lease 6 characters long";
            }
            if(empty($errors))
            {
                $data['Username'] = $_POST['Username'];
                $data['HashPassword'] = hash("sha256",$_POST['Password']);
                $data['RememberMe'] = isset($_POST['KeepAlive']);
                $response = login($data);
                if(!$response['Success'])
                {        
                    $errors["TableRenderError"] = $response['Error'];
                }
                else 
                {
                    redirect(ROOT.'/home');
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

    <title><?=APP_NAME?> - <?php echo $PageTitle ?></title>
    <link rel="icon" type="image/x-icon" type="image/ico" href="<?=ROOT?>/img/favicon.ico">

    <!-- Custom fonts for this template-->
    <link href="<?php echo ROOT?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo ROOT?>/public/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body style="background:#b2b2b2">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block" style="background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);">
                                <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                                    <img src="<?=ROOT?>/public/img/EFTLogoWhite.png" style="width: 100px; height: 90px;" />
                                    <h4 style="color: white;font-weight: bold;margin: 5px 0 0 0;">EFTVerifier</h4>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input name="Username" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Username / Email" value="<?php echo old_value("Username") ?>">
                                        </div>
                                        <div class="form-group">
                                            <input name="Password" minlength="6" maxlength="20" type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input name="keepAlive" type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button name="submitLoginForm" type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <!-- a class="small" href="forgot-password.html">Forgot Password?</a-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ALERTS -->
    <?php include("partials/alerts.php");?>
    <!-- END ALERTS -->
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo ROOT?>/public/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo ROOT?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo ROOT?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo ROOT?>/public/js/sb-admin-2.min.js"></script>
</body>
</html>