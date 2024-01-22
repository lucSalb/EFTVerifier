<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=ROOT?>">
        <img src="<?=ROOT?>/img/EFTLogoWhite.png" style="width:70px;height:50px"/>
        <div class="sidebar-brand-text mx-3">SMChecker</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Home -->
    <li class="nav-item <?php echo ($PageTitle == "Home") ? "active" : ""; ?>">
        <a class="nav-link" href="<?=ROOT?>">
        <i class="fas fa-home"></i>
            <span>Home</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Security module -->
    <li class="nav-item <?php echo ($PageTitle == "Register security module") ? "active" : ""; ?>">
        <a class="nav-link" href="<?=ROOT?>/registerModule">
        <i class="fas fa-key"></i>
            <span>Register security module</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Security module -->
    <li class="nav-item <?php echo (strstr(strtoupper($PageTitle),"USER")) ? "active" : ""; ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
        <div id="collapseUser" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Actions:</h6>
                <a class="collapse-item" href="<?=ROOT?>/RegisterUser">Register</a>
                <a class="collapse-item" href="<?=ROOT?>/users">Manage</a>
            </div>
        </div>
    </li>
     <!-- Divider -->
     <hr class="sidebar-divider my-0">
    <!-- Nav Item - Security module -->
        <!-- Nav Item - change password -->
    <li class="nav-item <?php echo ($PageTitle == "Change password") ? "active" : ""; ?>">
        <a class="nav-link" href="<?=ROOT?>/changePassword">
        <i class="fas fa-user"></i>
            <span>Change password</span></a>
    </li>
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Home -->
    <li class="nav-item">
        <form method="post" action="">
            <button name="submitLogOutForm" class="nav-link" type="submit" style="background: transparent;border-style: none;">
                <i class="fas fa-sign-out-alt"></i>
                    Logout
            </button>
        </form>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
