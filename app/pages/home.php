<?php
$PageTitle = "Home";
if (!empty($_SESSION['Removed_SM'])) {
    $server_messages['Removed'] = $_SESSION['Removed_SM'];
    unset($_SESSION['Removed_SM']);
}
if (!empty($_SESSION['EDITED_SM'])) {
    $server_messages['Edited'] = $_SESSION['EDITED_SM'];
    unset($_SESSION['EDITED_SM']);
}
if (!empty($_SESSION['EDITED_SM_ERROR'])) {
    $errors['EDITED_SM_ERROR'] = $_SESSION['EDITED_SM_ERROR'];
    unset($_SESSION['EDITED_SM_ERROR']);
}
function renderPagination($pageNo)
{
    $SMCount = getSecurityModulesCount();
    $totalPages = ceil($SMCount / 20);
    $adjacents = 2; // Number of adjacent pages to show on each side of the current page

    echo '<div class="container mt-5">
                <ul class="pagination" style="justify-content: center; flex-wrap: wrap;">';

    if ($totalPages <= 10) {
        // If total pages are less than or equal to 10, show all
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $pageNo) ? 'active' : '';
            echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
    } else {
        // Show the first page
        $activeClass = (1 == $pageNo) ? 'active' : '';
        echo "<li class='page-item $activeClass'><a class='page-link' href='?page=1'>1</a></li>";

        // Show dots if needed
        if ($pageNo > ($adjacents + 2)) {
            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }

        // Determine start and end page numbers
        $start = max(2, $pageNo - $adjacents);
        $end = min($totalPages - 1, $pageNo + $adjacents);

        // Loop through start to end pages
        for ($i = $start; $i <= $end; $i++) {
            $activeClass = ($i == $pageNo) ? 'active' : '';
            echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$i'>$i</a></li>";
        }

        // Show dots if needed
        if ($pageNo < ($totalPages - $adjacents - 1)) {
            echo "<li class='page-item disabled'><span class='page-link'>...</span></li>";
        }

        // Show the last page
        $activeClass = ($totalPages == $pageNo) ? 'active' : '';
        echo "<li class='page-item $activeClass'><a class='page-link' href='?page=$totalPages'>$totalPages</a></li>";
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
                            <th>Security module name</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Registered At</th>
                            <th>Registered By</th>
                            <th>Series No</th>
                            <th>Security module name</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>';
    foreach ($elements as $module) {
        echo '<tr>';
        echo '  <td>' . $module['RegisteredAt'] . '</td>';
        echo '  <td>' . $module['RegisteredBy'] . '</td>';
        echo '  <td>' . $module['SeriesNo'] . '</td>';
        echo '  <td>' . $module['Nickname'] . '</td>';
        echo '  <td>' . $module['SMStatus'] . '</td>';
        echo '  <td "width:80px"><a onclick="editSM(\'' . $module['SeriesNo'] . "','" . $module['Nickname'] . "','" . $module['SMStatus'] . '\')" class="delete-btn"><i class="fas fa-solid fa-edit"></i></a></td>';
        echo '  <td "width:80px"><a onclick="removeSM(\'' . $module['SeriesNo'] . '\')" class="delete-btn"><i class="fas fa-solid fa-trash"></i></a></td>';
        echo '</tr>';
    }
    echo '</tbody>
             </table>';
}
function processResponse($response, $pageNo)
{
    if (!$response['Success']) {
        $errors["TableRenderError"] = $response['Error'];
    } else {
        if (count($response['Structure']) > 0) {
            renderTable($response['Structure']);
            renderPagination($pageNo);
        } else {
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

    <title><?= APP_NAME ?> - <?php echo $PageTitle ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= ROOT ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= ROOT ?>/public/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= ROOT ?>/public/css/SMStyle.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" type="image/ico" href="<?= ROOT ?>/public/img/favicon.ico">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- MENU -->
        <?php include("partials/menu.php"); ?>
        <!-- END OF MENU -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- TOP BAR -->
                <?php include("partials/topBar.php") ?>
                <!-- END OF TOP BAR -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $PageTitle; ?></h1>
                        <a href="<?= ROOT ?>/registerModule"
                            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Register security module
                        </a>
                    </div>
                    <!-- Search Bar -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-0 my-2 my-md-3 mw-100 navbar-search col-12 p-0"
                        method="POST">
                        <div class="input-group col-5 p-0">
                            <input type="text" class="form-control bg-light border-1 small"
                                placeholder="Search security module..." aria-label="Search"
                                aria-describedby="basic-addon2" name="query">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registered modules</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
                                    $query = $_POST['query'];
                                    if (strlen($query) < 5) {
                                        $errors['invalidQuery'] = "Invalid security module lenght.";
                                    } else {
                                        $result = searchSecurityModule($query);
                                        if (!$result['Success']) {
                                            $errors['SearchError'] = $result['Error'];
                                        } else {
                                            if (sizeof($result['Structure']) < 1) {
                                                echo 'Security module not found.';
                                            } else {
                                                renderTable($result['Structure']);
                                            }
                                        }
                                    }
                                } else {
                                    $pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $response = getSecurityModules($pageNo);
                                    processResponse($response, $pageNo);
                                }
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
    <?php include("partials/alerts.php"); ?>
    <!-- END ALERTS -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= ROOT ?>/public/vendor/jquery/jquery.min.js"></script>
    <script src="<?= ROOT ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= ROOT ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= ROOT ?>/public/js/sb-admin-2.min.js"></script>
    <!--  -->
    <script>
        function removeSM(seriesNo) {
            var moduleForm = document.getElementById("ContentTextRemoveModule");
            moduleForm.innerText = "Are you sure you wish to remove the security module with series number: '" + seriesNo + "' ?";
            var smInput = document.getElementById('SMSNo');
            smInput.value = seriesNo;
            $('#deleteSMModal').modal('show');
        }
        function editSM(seriesNo, name, status) {
            var smInput = document.getElementById('SMEdtNo');
            smInput.value = seriesNo;

            var EditSMSeriesNo = document.getElementById('EditSMSeriesNo');
            EditSMSeriesNo.value = seriesNo;

            var EditSMName = document.getElementById('EditSMName');
            EditSMName.value = name;

            $('#EditSMModal').modal('show');
        }
    </script>
</body>

</html>