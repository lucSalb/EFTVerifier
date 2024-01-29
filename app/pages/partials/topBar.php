<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        if (isset($_POST['submitLogOutForm']))
        {
            logout();
        }
    }
    if (
        !isset($_SESSION['Username']) ||
        !isset($_SESSION['Name']) ||
        !isset($_SESSION['Id']) ||
        !isset($_SESSION['Email'])) {
         redirect(ROOT."/Login");
        //header("Location: ".ROOT."/Login", true, 301);
        exit();
    }
?>
<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
 
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item no-arrow" style="display: flex;align-items: center;">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo  $_SESSION['Name'] ?></span>
                        </li>
                    </ul>
</nav> 