/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validateUser(){
    
    //phone and email validated with the input types - change later
    //change this function to recieve input type - general function for all
    
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var phone = $('#phone').val();
    var city = $('#city').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm_password').val();

    if(firstname === ""){
        $('#errFirstname').show();
        $('#firstname').focus();
        return false;
    }

    if(lastname === ""){
        $('#errLastname').show();
        $('#lastname').focus();
        return false;
    }

    if(city === ""){
        $('#errCity').show();
        $('#city').focus();
        return false;
    }

    if(password === ""){
        $('#errPassword').show();
        $('#password').focus();
        return false;
    }

    if(confirmPassword === ""){
        $('#errConfirmPassword').show();
        $('#confirm_password').focus();
        return false;
    }

    if(confirmPassword !== password){
        $('#confirmPass').show();
        $('#confirm_password').focus();
        return false;
    }
    return true;
}


