$(document).ready(function() {

    $("#hideLogin").click(function() {
        // console.log("Login was pressed"); // to check if it is work
        $("#loginForm").hide();
        $("#registerForm").show();
    });

    $("#hideRegister").click(function() {
        // console.log("register was pressed"); // to check if it is work
        $("#loginForm").show();
        $("#registerForm").hide();
    });

});