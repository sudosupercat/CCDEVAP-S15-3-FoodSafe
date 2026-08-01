function showNavBar(){
    //Check current path
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".php", "");  

    let navItems = "";
    let basePath = "";

    // const ROOT = "/CCDEVAP-S15-3-FOODSAFE/";
}

function applyLightMode(){
    document.body.classList.remove('theme-dark-custom', 'text-white');
    document.querySelectorAll('table').forEach(table => {
        table.classList.remove('table-dark');
    });
    document.querySelectorAll('.form-container').forEach(div => {
        div.classList.remove('theme-dark-custom');
    });
    document.querySelectorAll('.modal').forEach(div => {
        div.removeAttribute('data-bs-theme');
    });
}

function applyDarkMode(){
    document.body.classList.add('theme-dark-custom', 'text-white');
    document.querySelectorAll('table').forEach(table => {
        table.classList.add('table-dark');
    });
    document.querySelectorAll('.form-container').forEach(div => {
        div.classList.add('theme-dark-custom');
    });
    document.querySelectorAll('.modal').forEach(div => {
        div.setAttribute('data-bs-theme', 'dark');
    });
}

// Cookie helper functions
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setDate(date.getDate() + days);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
    var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
    return match ? match[1] : null;
}

//Only execute when the page has finished loading
document.addEventListener("DOMContentLoaded", () => {
    showNavBar();
    
    const themeSwitcher = document.getElementById('themeSwitcher');
    if(getCookie('theme') == 'dark'){
        themeSwitcher.checked = true;
        applyDarkMode();
    }
    else if(getCookie('theme') == 'light'){
        themeSwitcher.checked = false;
        applyLightMode();
    }

    themeSwitcher.addEventListener('change', function () {
        if(this.checked) {
            applyDarkMode();
            setCookie('theme', 'dark', 30);
        }
        else{
            applyLightMode();
            setCookie('theme', 'light', 30);
        }
    });
});