function adjustForm (value) {
    let element = document.getElementById("finput")
    if (value == "name" || value == "surname") {
        element.type = "text";
        element.placeholder = '';
    }
    else if (value == "birth_number") {
        element.type = "text";
        element.placeholder = "XXXXXX/XXXX";
    }
    else if (value == "date_of_death" || value == "date_of_birth"){
        element.type = "date";
        element.placeholder = '';
    }
}

function personValidation() {
    let name = document.getElementById("fname").value;
    let surname = document.getElementById("fsurname").value;
    let birth_date = document.getElementById("fbirth_date").value;
    let birth_number = document.getElementById("fbirth_number").value;

    if (!name || !surname || !birth_date) {
        window.alert("Please fill out all the fields!");
        return false;
    }

    if (!birth_number.match(/^[0-9]{6}\/[0-9]{3,4}$/)) {
        window.alert("Enter a valid birth number!");
        return false;
    }

    return true;
}

function registerValidation () {
    if (!personValidation()) {return false;}
    let phone = document.getElementById("fphone").value;
    let password = document.getElementById("fpassword").value;
    let password2 = document.getElementById("fpassword2").value;

    if (password.length < 3) {
        window.alert("Password is too short!");
        return false;
    }
    if (password != password2) {
        window.alert("Passwords do not match!");
        return false;
    }
    
    if (!phone.match(/^\+[0-9]{1,3}[0-9 ]+$/)) {
        window.alert("Enter a valid phone number!");
        return false;
    }

    if (confirm("Are you sure you want to submit?")) {
        document.getElementById("registration").submit();
    }
    return true;
}

function dRegisterValidation() {
    if (!personValidation()) {return false;}

    if (confirm("Are you sure you want to submit?")) {
        document.getElementById("registration").submit();
    }
    return true;
}

function eRegisterValidation() {
    if (!personValidation()) {return false;}

    let password = document.getElementById("fpassword").value;
    let password2 = document.getElementById("fpassword2").value;

    if (password.length < 3) {
        window.alert("Password is too short!");
        return false;
    }
    if (password != password2) {
        window.alert("Passwords do not match!");
        return false;
    }

    if (confirm("Are you sure you want to submit?")) {
        document.getElementById("registration").submit();
    }
    return true;
}

function loginSubmit() {
    let birth_number = document.getElementById("fbirth_number").value;
    let password = document.getElementById("fpassword").value;

    if (!birth_number.match(/^[0-9]{6}\/[0-9]{3,4}$/)) {
        window.alert("Enter a valid birth number!");
        return false;
    }
    document.getElementById("login").submit();
    return true;
}

function error($msg) {
    window.alert($msg);
    window.location.replace("index.php");
}