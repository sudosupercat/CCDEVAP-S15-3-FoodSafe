function showNavBar(){
    //Check current path
    const path = window.location.pathname;
    const page = path.split("/").pop().replace(".php", "");  

    let navItems = "";
    let basePath = "";

    // const ROOT = "/CCDEVAP-S15-3-FOODSAFE/";
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