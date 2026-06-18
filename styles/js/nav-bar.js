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
            <li class="nav-item"><a class="nav-link" href="../admin/dashboard.html">Dashboard</a></li>
        `;
    }
    else if(path.includes("/inspector/")){
        basePath = "../../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../inspector/dashboard.html">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/inspection-entry.html">Log Entry</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/business-directory.html">Business Directory</a></li>
            <li class="nav-item"><a class="nav-link" href="../login.html">Logout</a></li>
        `
    }
    else if(path.includes("/public/")){
        basePath = "../../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../public/complaint.html">Report</a></li>
            <li class="nav-item"><a class="nav-link" href="../login.html">Login</a></li>
        `;
    }
    else if (path.includes("login")){
        basePath = "../";
        navItems = `
            <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
        `;
    } else {
        navItems = `
            <li class="nav-item"><a class="nav-link" href="users/public/complaint.html">Report</a></li>
            <li class="nav-item"><a class="nav-link" href="users/login.html">Login</a></li>
        `;
    }

    const navBarHTML = `
        <nav class="navbar navbar-expand-lg navbar-dark navbar-foodsafe-custom sticky-top">
            <div class="container-fluid">
                <img src="${basePath}src/images/logo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
                <a class="navbar-brand font-weight-bold" href="#">FoodSafe</a>

                <button class="navbar-toggler" type="button" 
                        data-toggle="collapse" data-target="#navbar-items">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-items">
                    <div class="custom-control custom-switch mb-2">
                        <input type="checkbox" class="custom-control-input" id="themeSwitcher">
                        <label class="custom-control-label" for="themeSwitcher">Dark Mode</label>
                    </div>
                    <ul class="navbar-nav ml-auto">
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