function showNavBar(){
    //Check current path
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".html", "");  

    let navItems = "";

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
                <a class="navbar-brand" href="#">FoodSafe</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarNav" aria-controls="navbarNav" 
                        aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        ${navItems}
                    </ul>
                </div>
            </div>
        </nav>
        `;
    document.getElementById("navBar").innerHTML = navBarHTML;
}

document.addEventListener("DOMContentLoaded", () => {
  showNavBar();
});