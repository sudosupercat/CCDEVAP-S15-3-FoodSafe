function showNavBar(){
    //Check current path
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".html", "");  

    let navItems = "";

    //Change items based on webpage location
    if(path.includes("/admin/")){
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../admin/dashboard.html">Dashboard</a></li>
        `;
    }
    else if(path.includes("/inspector/")){
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../inspector/dashboard.html">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="../inspector/inspection-entry.html">Log Entry</a></li>
            <li class="nav-item"><a class="nav-link" href="../logout.html">Logout</a></li>
        `
    }
    else if(path.includes("/public/")){
        navItems = `
            <li class="nav-item"><a class="nav-link" href="../public/complaint.html">Report</a></li>
            <li class="nav-item"><a class="nav-link" href="../login.html">Login</a></li>
        `;
    }

    const navBarHTML = `
        <nav class="navbar navbar-expand-lg navbar-dark navbar-foodsafe-custom">
            <div class="container-fluid">
                <img src="../../src/images/logo.png" width="30" height="30" class="d-inline-block align-top mr-2" alt="">
                <a class="navbar-brand font-weight-bold" href="#">FoodSafe</a>

                <button class="navbar-toggler" type="button" 
                        data-toggle="collapse" data-target="#navbar-items"
                        aria-controls="navbar-items" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbar-items">
                    <div class="d-flex ml-auto align-items-center">
                        <div class="custom-control custom-switch ml-auto">
                            <input type="checkbox" class="custom-control-input" id="themeSwitcher">
                            <label class="custom-control-label" for="themeSwitcher">Dark Mode</label>
                        </div>
                        <ul class="navbar-nav ml-auto">
                            ${navItems}
                        </ul>
                    </div>
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
      if (this.checked) {
        document.body.classList.add('theme-dark-custom', 'text-white');
        document.querySelectorAll('table').forEach(table => {
            table.classList.add('table-dark');
        });
      } else {
        document.body.classList.remove('theme-dark-custom', 'text-white');
        document.querySelectorAll('table').forEach(table => {
            table.classList.remove('table-dark');
        });
    }
    });
});