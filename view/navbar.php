<?php

$navItems = [];
$homepage = "login";

if (isset($_SESSION['role'])){
    $userRole = $_SESSION['role'];
}
else{
    $userRole = '';
}


// if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'){
//     $homepage = "adminDashboard";
//     $navItems = ['<li class="nav-item"><a class="nav-link" href="/adminDashboard">Dashboard</a></li>',
//                 '<li class="nav-item"><a class="nav-link" href="/adminUsers">Users</a></li>',
//                 '<li class="nav-item"><a class="nav-link" href="/businessDirectory">Business Directory</a></li>',
//                 '<li class="nav-item"><a class="nav-link" href="/inspectorReports">Reports</a></li>',
//                 '<li class="nav-item"><a class="nav-link" href="/logout"><span><i class="bi bi-box-arrow-right me-1"></i></span>Logout</a></li>'];
// }
// else if(isset($_SESSION['role']) && $_SESSION['role'] === 'Inspector'){
//     $homepage = "inspectorDashboard";    
//     $navItems = ['<li class="nav-item"><a class="nav-link" href="/inspectorDashboard"><span><i class="bi bi-speedometer me-1"></i></span>Dashboard</a></li>',
//             '<li class="nav-item"><a class="nav-link" href="/inspectionEntry"><span><i class="bi bi-file-earmark-plus me-1"></i></span>Log Entry</a></li>',
//             '<li class="nav-item"><a class="nav-link" href="/businessDirectory"><span><i class="bi bi-briefcase me-1"></i></span>Business Directory</a></li>',
//             '<li class="nav-item"><a class="nav-link" href="/inspectorReports"><span><i class="bi bi-flag me-1"></i></span>Reports</a></li>',
//             '<li class="nav-item"><a class="nav-link" href="/logout"><span><i class="bi bi-box-arrow-right me-1"></i></span>Logout</a></li>'];
// }
// else {
//     $navItems = ['<li class="nav-item"><a class="nav-link" href="/report"><span><i class="bi bi-flag me-1"></i></span>Report</a></li>',
//                 '<li class="nav-item"><a class="nav-link" href="/login"><span><i class="bi bi-box-arrow-right me-1"></i></span>Login</a></li>'];
// }

if ($userRole === 'Admin'){
    $homepage = "/adminDashboard";
    $navItems = [
        ['uri' => '/adminDashboard',     'name' => 'Dashboard',             'icon' => 'bi-speedometer'],
        ['uri' => '/adminUsers',         'name' => 'Users',                 'icon' => 'bi-people'],
        ['uri' => '/businessDirectory',  'name' => 'Business Directory',    'icon' => 'bi-briefcase'],
        ['uri' => '/inspectorReports',   'name' => 'Reports',               'icon' => 'bi-flag'],
        ['uri' => '/logout',             'name' => 'Logout',                'icon' => 'bi-box-arrow-right']
    ];
}
else if($userRole === 'Inspector'){
    $homepage = "/inspectorDashboard";    
    $navItems = [
        ['uri' => '/inspectorDashboard', 'name' => 'Dashboard',             'icon' => 'bi-speedometer'],
        ['uri' => '/inspectionEntry',    'name' => 'Inspection Entry',      'icon' => 'bi-file-earmark-plus'],
        ['uri' => '/businessDirectory',  'name' => 'Business Directory',    'icon' => 'bi-briefcase'],
        ['uri' => '/inspectorReports',   'name' => 'Reports',               'icon' => 'bi-flag'],
        ['uri' => '/logout',             'name' => 'Logout',                'icon' => 'bi-box-arrow-right']
    ];
}
else {
   $navItems = [
        ['uri' => '/report',     'name' => 'Report',     'icon' => 'bi-flag'],
        ['uri' => '/login',      'name' => 'Login',      'icon' => 'bi-box-arrow-right']
    ];
}
?>

<nav class="navbar navbar-expand-lg navbar-dark navbar-foodsafe-custom sticky-top">
    <div class="container-fluid">
        <img src="src/images/logo.png" width="30" height="30" class="d-inline-block align-text-top me-2" alt="">
        <a class="navbar-brand fw-bold" href="<?= $homepage; ?>">FoodSafe</a>

        <button class="navbar-toggler" type="button" 
                data-bs-toggle="collapse" data-bs-target="#navbar-items">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbar-items">
            <div class="form-check form-switch mb-2">
                <input type="checkbox" class="form-check-input" id="themeSwitcher">
                <label class="form-check-label" for="themeSwitcher">Dark Mode</label>
            </div>
            <ul class="navbar-nav ms-auto">
                <?php foreach($navItems as $navItem):?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $navItem['uri']; ?>">
                    <span><i class="bi <?= $navItem['icon']; ?> me-1"></i></span><?= $navItem['name']; ?>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</nav>