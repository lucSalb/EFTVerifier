<?php 
    $PageTitle = "Home";
    if(!empty($_SESSION['Removed_SM']))
    {
        $server_messages['Removed'] = $_SESSION['Removed_SM'];
        unset($_SESSION['Removed_SM']);
    }
    function renderPagination($pageNo)
    {
        $SMCount = getSecurityModulesCount();
        $totalPages = ceil($SMCount / 20);
        echo '<div class="container mt-5">
                <ul class="pagination" style="justify-content: center;">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    $activeClass = ($i == $pageNo) ? 'active' : '';
                    echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
        echo '  </ul>
              </div>';
    }
    function renderTable($elements)
    {
        echo '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Registered At</th>
                            <th>Registered By</th>
                            <th>Series No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Registered At</th>
                            <th>Registered By</th>
                            <th>Series No</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';
                foreach ($elements as $module)
                {
                    echo '<tr>';
                    echo '  <td>'.$module['RegisteredAt'].'</td>';
                    echo '  <td>'.$module['RegisteredBy'].'</td>';
                    echo '  <td>'.$module['SeriesNo'].'</td>';
                    echo '  <td "width:80px"><a onclick="removeSM(\'' . $module['SeriesNo'] . '\')" class="delete-btn"><i class="fas fa-solid fa-trash"></i></a></td>';
                    echo '</tr>';
                }                                
        echo        '</tbody>
             </table>';
    }
    function processResponse($response,$pageNo)
    {
        if(!$response['Success'])
        {        
            $errors["TableRenderError"] = $response['Error'];
        }
        else 
        {
            if(count($response['Structure']) > 0)
            {
                renderTable($response['Structure']);
                renderPagination($pageNo);
            }
            else
            {
                echo "No security modules added.";
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

    <title><?=APP_NAME?> - <?php echo $PageTitle?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=ROOT?>//css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?=ROOT?>/css/SMStyle.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon"   type="image/ico" href="<?=ROOT?>/img/favicon.ico">

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
                        <a href="<?=ROOT?>/registerModule" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus fa-sm text-white-50"></i> 
                            Register security module
                        </a>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registered modules</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                    $pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $response = getSecurityModules($pageNo);
                                    processResponse($response, $pageNo);
                                ?>
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
    <script src="<?=ROOT?>//vendor/jquery/jquery.min.js"></script>
    <script src="<?=ROOT?>//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=ROOT?>//vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=ROOT?>//js/sb-admin-2.min.js"></script>
    <!--  -->
    <script>

    function removeSM(seriesNo){
        var moduleForm = document.getElementById("ContentTextRemoveModule");
        moduleForm.innerText = "Are you sure you wish to remove the security module with series number: '" + seriesNo +"' ?";
        var smInput = document.getElementById('SMSNo');
        smInput.value=seriesNo;
        $('#deleteSMModal').modal('show');
    }
    </script>
</body>
</html>