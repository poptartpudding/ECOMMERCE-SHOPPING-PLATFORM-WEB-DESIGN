// Validate inputs under Billing Information
function validateBilling_Add(id) {
    switch (id) {
        case 1:
            var first = document.getElementById("FirstName").value;
            var regexp = /^[a-z]+$/;
            if (regexp.test(first)) {
                document.getElementById("first_name_validation_text").innerHTML = "";
                return true;
            }
            else {
                document.getElementById("first_name_validation_text").innerHTML = "Alphabet letters only";
                return false;
            }
        case 2:
            var last = document.getElementById("lastname").value;
            var regexp = /^[a-z]+$/;
            if (regexp.test(last)) {
                document.getElementById("last_name_validation_text").innerHTML = "";
                return true;
            } else {
                document.getElementById("last_name_validation_text").innerHTML = "Alphabet letters only";
                return false;
            }
        case 3:
            var cty = document.getElementById("country").value;
            var regexp = /^[a-z]+$/;
            if (regexp.test(cty)) {
                document.getElementById("country_validation_text").innerHTML = "";
                return true;
            } else {
                document.getElementById("country_validation_text").innerHTML = "Alphabet letters only";
                return false;
            }
        case 4:
            var street = document.getElementById("Street_address").value;
            var regexp = /^[a-z]+\s{1}\d+\s{1}[a-z]+$/;
            if (regexp.test(street)) {
                document.getElementById("street_validation_text").innerHTML = "";
                return true;
            }
            else {
                document.getElementById("street_validation_text").innerHTML = "Alphabet(s), 1 Space, Digit(s), 1 Space, Alphabet(s)";
                return false;
            }
        case 5:
            var unit = document.getElementById("Unit_No").value;
            var regexp = /^\d+-{1}\d+$/;
            if (regexp.test(unit)) {
                document.getElementById("unit_validation_text").innerHTML = "";
                return true;
            }
            else {
                document.getElementById("unit_validation_text").innerHTML = "Format: xxx-xxx. Digits and 1 Hyphen only";
                return false;
            }
        case 6:
            var postal = document.getElementById("Postal_code").value;
            var regexp = /^\d+$/;
            if (regexp.test(postal)) {
                document.getElementById("postal_validation_text").innerHTML = "";
                return true;
            }
            else {
                document.getElementById("postal_validation_text").innerHTML = "Digits only";
                return false;
            }
        case 7:
            var city_input = document.getElementById("city").value;
            var regexp = /^[a-z]+$/;
            if (regexp.test(city_input)) {
                document.getElementById("city_validation_text").innerHTML = "";
                return true;
            }
            else {
                document.getElementById("city_validation_text").innerHTML = "Alphabet letters only";
                return false;
            }
    }
}
//Validate inputs under Payment Method
function validatePayment(id) {
    switch (id) {
        case 1:
            var mobile = document.getElementById("hp_number").value;
            var regexp = /^[0-9]{8}$/;
            if (mobile.length > 0) {
                if (regexp.test(mobile)) {
                    document.getElementById("mobile_validation_text").innerHTML = "";
                    return true;
                }
                else {
                    document.getElementById("mobile_validation_text").innerHTML = "8 digits only";
                    return false;
                }
            }
            else {
                document.getElementById("mobile_validation_text").innerHTML = "Input is required";
                return false;
            }

        case 2:
            elem = document.getElementById("card_number");
            if (elem.value.length > 0) {
                document.getElementById("card_validation_text").innerHTML = "";
                if (elem.value.length <= 19) {
                    if (elem.value.length === 4) {
                        elem.value = elem.value + '-';
                    }
                    if (elem.value.length === 9) {
                        elem.value = elem.value + '-';
                    }
                    if (elem.value.length === 14) {
                        elem.value = elem.value + '-';
                    }
                    if (elem.value.length === 19) {
                        return true;
                    }
                } else {
                    elem.value = elem.value.slice(0, -1)
                }
                return true;
            }
            else {
                document.getElementById("card_validation_text").innerHTML = "Input is required"
                return false;
            }
        case 3:
            var date_input = new Date(document.getElementById("exp_date").value);
            var today = new Date();
            if (date_input.getFullYear() > today.getFullYear()) {
                document.getElementById("expiry_validation_text").innerHTML = "";
                return true;
            }
            else if (date_input.getFullYear() == today.getFullYear()) {
                if (date_input.getMonth() < today.getMonth()) {
                    document.getElementById("expiry_validation_text").innerHTML = "Past dates not accepted";
                    return false;
                }
                else {
                    document.getElementById("expiry_validation_text").innerHTML = "";
                    return true;
                }
            }
            else {
                document.getElementById("expiry_validation_text").innerHTML = "Past dates not accepted";
                return false;
            }
        case 4:
            var ccv_input = document.getElementById("ccv").value;
            if (ccv_input.length > 0) {
                var regexp = /^[0-9]{3}$/;
                if (regexp.test(ccv_input)) {
                    document.getElementById("ccv_validation_text").innerHTML = "";
                    return true;
                }
                else {
                    document.getElementById("ccv_validation_text").innerHTML = "Must be exactly 3 digits";
                    return false;
                }
            }
            else {
                document.getElementById("ccv_validation_text").innerHTML = "Input is required";
                return false;
            }
        case 5:
            var username = document.getElementById("custName").value;
            if (username.length > 0) {
                var regexp = /^[a-z]+\s{1}[a-z]+$/;
                if (regexp.test(username)) {
                    document.getElementById("name_validation_text").innerHTML = "";
                    return true;
                }
                else {
                    document.getElementById("name_validation_text").innerHTML = "Alphabets separated with a space";
                    return false;
                }
            }
            else {
                document.getElementById("name_validation_text").innerHTML = "Input is required";
                return false;
            }
    }
}
//Display error message: "Input is Required" for empty fields
function require_input() {
    var first_input = document.getElementById("FirstName").value;
    var last_input = document.getElementById("lastname").value;
    var cty_input = document.getElementById("country").value;
    var city_input1 = document.getElementById("city").value;
    var street_input = document.getElementById("Street_address").value;
    var unit_input = document.getElementById("Unit_No").value;
    var postal_input = document.getElementById("Postal_code").value;
    var mobile_input = document.getElementById("hp_number").value;
    var card_input = document.getElementById("card_number").value;
    var expiry_input = document.getElementById("exp_date").value;
    var ccv_input1 = document.getElementById("ccv").value;
    var name_input = document.getElementById("custName").value;
    if (first_input.length == 0) {
        document.getElementById("first_name_validation_text").innerHTML = "Input is required";
    }

    if (last_input.length == 0) {
        document.getElementById("last_name_validation_text").innerHTML = "Input is required";
    }
    if (cty_input.length == 0) {
        document.getElementById("country_validation_text").innerHTML = "Input is required";
    }
    if (city_input1.length == 0) {
        document.getElementById("city_validation_text").innerHTML = "Input is required";
    }
    if (street_input.length == 0) {
        document.getElementById("street_validation_text").innerHTML = "Input is required";
    }
    if (unit_input.length == 0) {
        document.getElementById("unit_validation_text").innerHTML = "Input is required";
    }
    if (postal_input.length == 0) {
        document.getElementById("postal_validation_text").innerHTML = "Input is required";
    }
    if (mobile_input.length == 0) {
        document.getElementById("mobile_validation_text").innerHTML = "Input is required";
    }
    if (card_input.length == 0) {
        document.getElementById("card_validation_text").innerHTML = "Input is required";
    }
    if (expiry_input.length == 0) {
        document.getElementById("expiry_validation_text").innerHTML = "Input is required";
    }
    if (ccv_input1.length == 0) {
        document.getElementById("ccv_validation_text").innerHTML = "Input is required";
    }
    if (name_input.length == 0) {
        document.getElementById("name_validation_text").innerHTML = "Input is required";
    }
    if (document.getElementById('pp').checked) {
        if (mobile_input.length == 0) {
            return false;
        }
        else {
            return true;
        }
    }
    else if (document.getElementById('cc').checked) {
        if ((card_input.length == 0) || (expiry_input.length == 0) || (ccv_input1.length == 0) || (name_input.length == 0)) {
            return false;
        }
        else {
            return true;
        }
    }
}
//Check that all fields are of required format and filled up
function checkFields() {
    if (document.getElementById('pp').checked) {
        if ((require_input() == false) || (validatePayment(1) == false) || (validateBilling_Add(1) == false) || (validateBilling_Add(2) == false) || (validateBilling_Add(3) == false) || (validateBilling_Add(4) == false) || (validateBilling_Add(5) == false) || (validateBilling_Add(6) == false) || (validateBilling_Add(7) == false)) {
            alert("please ensure you have filled up all required fields and input them in correct format");
            return false;

        }
    }
    else if (document.getElementById('cc').checked) {
        if ((require_input() == false) || (validatePayment(2) == false) || (validatePayment(3) == false) || (validatePayment(4) == false) || (validatePayment(5) == false) || (validateBilling_Add(1) == false) || (validateBilling_Add(2) == false) || (validateBilling_Add(3) == false) || (validateBilling_Add(4) == false) || (validateBilling_Add(5) == false) || (validateBilling_Add(6) == false) || (validateBilling_Add(7) == false)) {
            alert("Please ensure you have filled up all required fields and input correct format")
            return false;
        }
    }
    else if (!(document.getElementById('googlepay_link').checked)) {
        alert("Please tick at least 1 payment method");
        return false;
    }
}


function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}