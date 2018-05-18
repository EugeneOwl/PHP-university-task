(function() {
    let goToLoginButton = document.getElementById("goToLoginButton");
    let goToRegistrationButton = document.getElementById("goToRegButton");

    let loginForm = document.getElementById("loginForm");
    let registrationForm = document.getElementById("logupForm");

    registrationForm.style.display = "none";

    goToLoginButton.onclick = () => {
        loginForm.style.display = "block";
        registrationForm.style.display = "none";
    };

    goToRegistrationButton.onclick = () => {
        registrationForm.style.display = "block";
        loginForm.style.display = "none";
    };

}) ();