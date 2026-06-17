let toastTimeout;

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.querySelector("#loginForm");
    const emailField = document.querySelector("#email");
    const passwordField = document.querySelector("#password");
    const showPw = document.querySelector("#showPw");

    if (loginForm) {
        loginForm.reset(); //refresh
    }
    //for refresh 
    if (passwordField) {
        passwordField.setAttribute("type", "password");
    }

    //toggle password
    showPw.addEventListener("change", function () {
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);
    });

    //Handle authentication submissions and dispatch validation parameters
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault(); // Stop frontend page reloading

        const emailValue = emailField.value.trim();
        const passwordValue = passwordField.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (emailValue === "") {
            showToast("error", "Error", "Please enter your email address.");
        } 
        else if (!emailRegex.test(emailValue)) {
            showToast("error", "Error", "Please enter a valid email address.");
        } 
        else if (passwordValue === "") {
            showToast("error", "Error", "Please enter your password.");
        } 
        else if (passwordValue.length < 6) {
            showToast("error", "Error", "Password must be at least 6 characters long.");
        } 
        else {
            showToast("success", "Login Successful", "Welcome back to FoodSafe!");
        }
    });
});


//Toast functions
function showToast(type, title, message) {
    const toast = document.getElementById('toast');

    document.getElementById('toast-title').textContent = title;
    document.getElementById('toast-message').textContent = message;

    // Clear background properties to avoid overlapping state values
    toast.classList.remove('success', 'error');
    toast.classList.remove('hidden');
    toast.classList.add(type);

    clearTimeout(toastTimeout);

    toastTimeout = setTimeout(() => {
        toast.classList.add('hidden');
        toast.classList.remove(type);
    }, 5000);
}

function hideToast() {
    const toast = document.getElementById('toast');

    toast.classList.add('hidden');
    toast.classList.remove('success', 'error');

    clearTimeout(toastTimeout);
}