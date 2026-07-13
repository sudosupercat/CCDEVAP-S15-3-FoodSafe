function showNavBar(){
    //Check current path
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".html", "");  

    let navItems = "";
    let basePath = "";

    //Change items based on webpage location
    if(path.includes("/admin/")){
        basePath = "../../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../admin/dashboard.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/business-directory.php">Business Directory</a></li>
        `;
    }
    else if(path.includes("/inspector/")){
        basePath = "../../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../inspector/dashboard.php"><span><i class="bi bi-speedometer me-1"></i></span>Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/inspection-entry.php"><span><i class="bi bi-file-earmark-plus me-1"></i></span>Log Entry</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/business-directory.php"><span><i class="bi bi-briefcase me-1"></i></span>Business Directory</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/reports.php"><span><i class="bi bi-flag me-1"></i></span>Reports</a></li>
            <li class="nav-item"><a class="nav-link" href="../login.php"><span><i class="bi bi-box-arrow-right me-1"></i></span>Logout</a></li>
        `
    }
    else if(path.includes("/public/")){
        basePath = "../../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="${basePath}view/public/complaint.php"><span><i class="bi bi-flag me-1"></i></span>Report</a></li>
            <li class="nav-item"><a class="nav-link" href="${basePath}view/login.php"><span><i class="bi bi-box-arrow-right me-1"></i></span>Login</a></li>
        `;
    }
    else if (path.includes("login")){
        basePath = "../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="${basePath}view/login.php"><span><i class="bi bi-lock me-1"></i></span>Login</a></li>
        `;
    } else {
        navItems = `
            <li class="nav-item"><a class="nav-link" href="view/public/complaint.php"><span><i class="bi bi-flag me-1"></i></span>Report</a></li>
            <li class="nav-item"><a class="nav-link" href="view/login.php"><span><i class="bi bi-lock me-1"></i></span>Login</a></li>
        `;
    }

    const navBarHTML = `
        <nav class="navbar navbar-expand-lg navbar-dark navbar-foodsafe-custom sticky-top">
            <div class="container-fluid">
                <img src="${basePath}src/images/logo.png" width="30" height="30" class="d-inline-block align-text-top me-2" alt="">
                <a class="navbar-brand fw-bold" href="#">FoodSafe</a>

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
                        ${navItems}
                    </ul>
                </div>
            </div>
        </nav>
        `;

    document.getElementById("navBar").innerHTML = navBarHTML;
}

//Only execute when the page has finished loading
document.addEventListener("DOMContentLoaded", () => {
    showNavBar();

    const themeSwitcher = document.getElementById('themeSwitcher');

    themeSwitcher.addEventListener('change', function () {
      if(this.checked) {
        document.body.classList.add('theme-dark-custom', 'text-white');
        document.querySelectorAll('table').forEach(table => {
            table.classList.add('table-dark');
        });
        document.querySelectorAll('.form-container').forEach(div => {
            div.classList.add('theme-dark-custom');
        });

      }
      else{
        document.body.classList.remove('theme-dark-custom', 'text-white');
        document.querySelectorAll('table').forEach(table => {
            table.classList.remove('table-dark');
        });
        document.querySelectorAll('.form-container').forEach(div => {
            div.classList.remove('theme-dark-custom');
        });
    }
    });
});