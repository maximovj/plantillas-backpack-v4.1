/*
 * Victor J. 
 * desc Custom JavaScript
 */

function redirectOnChange(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const dataRoute = selectedOption.getAttribute("data-route");

    if (dataRoute == null) {
        return false;
    }

    window.location.href = dataRoute;
}

function redirectToGo(element) {
    const dataRoute = element.getAttribute("data-route");
    if (dataRoute == null) {
        return false;
    }
    window.location.href = dataRoute;
}

function fnReloadPage() {
    window.location.reload();
}

function togglePasswordVisibility(field_id) {
    var passwordField = $('#' + field_id);
    var toggleIcon = $('#' + 'toggle-password-' + field_id);

    // Alterna entre 'password' y 'text' para cambiar la visibilidad
    var fieldType = passwordField.attr('type') === 'password' ? 'text' : 'password';
    passwordField.attr('type', fieldType);

    // Cambia el icono según el tipo de campo de contraseña
    toggleIcon.removeClass(fieldType === 'password' ? 'la-eye-slash' : 'la-eye');
    toggleIcon.addClass(fieldType === 'password' ? 'la-eye' : 'la-eye-slash');
}

function checkStrongPassword(field_id) {
    var myInput = $('#' + field_id).val().trim();
    var pattern = /^(?=.{6,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W])/;
    var checkval = pattern.test(myInput);
    var security = myInput.length;

    if (checkval) {
        security = security * 5;
    }

    var progressBar = $('#progress-bar-' + field_id);
    progressBar.attr('data-width', security);

    if (security >= 100) {
        progressBar.attr('data-width', '100');
    } else if (security >= 60) {
        progressBar.attr('data-width', '60');
    } else if (security >= 30) {
        progressBar.attr('data-width', '30');
    } else {
        progressBar.attr('data-width', '0');
    }

    $('#progress-bar-' + field_id).css('width', security + '%');
}