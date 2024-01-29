<?php
    $PageTitle ="Register security module";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['submitRegistrationForm']))
        {
            $errors = [];
            if(empty($_POST['SeriesNo']))
            {
                $errors['SeriesNo'] = "Series number is required";
            }
            elseif(strlen($_POST['SeriesNo']) < 6)
            {
                $errors['SeriesNo'] = "Too short value for security module series number";
            }else
            {
                $result = validateSeriesNo($_POST['SeriesNo']);
                if(!$result['Success'])
                {
                    $errors['searchError'] = $result['Error'];
                }
                else
                {
                    if(!$result['Structure']) $errors['ErrorSMRegistered'] = "Security module is already registered.";
                }
            }
            if(empty($errors))
            {
                $data = [];
                $data["RegisteredAt"] = date("y-m-d");
                $data["RegisteredBy"] = $_SESSION['Name'];
                $data["SeriesNo"] = str_replace(' ', '', $_POST['SeriesNo']);  
                $response = addSecurityModule($data);
                if(!$response['Success'])
                {
                    $errors['registrationError'] = $response['Error'];
                }
                else
                {
                    $server_messages['Success'] = $response['Message'];
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

    <title><?=APP_NAME?> - Register security module</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Security module</h1>
                    </div>
 
                    <!-- DataTales Example -->
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Security module information</h1>
                                        </div>
                                        <form class="user" method="post">
                                            <div class="form-group row">
                                                <div class="col-sm-12 mb-3 mb-sm-0">
                                                    <input type="text" value="<?php echo old_value('SeriesNo')?>" class="form-control form-control-user" id="SMSeriesNo" name="SeriesNo"
                                                        placeholder="Security module series number">
                                                </div>
                                            </div>
                                            <button name="submitRegistrationForm" type="submit" class="btn btn-primary btn-user btn-block">
                                                Register
                                            </button>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="height:550px; position: relative;">
                                    <div id="reader" style="width: 100%; height:100%; border:0px" hidden></div>
                                    <div id="notReading" style="background: black; opacity: .8; position: absolute; left: 0; right: 0; top: 0; bottom: 0; display: flex; justify-content: center; align-items: center;">
                                        <a style="width: 100px; height: 100px; background: gray; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                                            <i class="fas fa-solid fa-qrcode" style="color:black; font-size:50px"></i>
                                        </a>
                                    </div>
                                    <button id="runBtn" type="button" onclick="CameraControl()" class="btn btn-primary open-camera-btn" style="position: absolute; bottom: 20px;">Start capture</button>
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

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Alert dialog  error-->
    <?php include("partials/alerts.php");?>
    <!-- End of alert dialog  error-->


    <!-- Bootstrap core JavaScript-->
    <script src="<?=ROOT?>/public/vendor/jquery/jquery.min.js"></script>
    <script src="<?=ROOT?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=ROOT?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=ROOT?>/public/js/sb-admin-2.min.js"></script>
 
    <script src="<?=ROOT?>/public/js/html5-qrcode.min.js"></script>
    <script src="<?=ROOT?>/public/js/register.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>