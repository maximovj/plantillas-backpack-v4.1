/*
 * Victor J. <victor.maximo@mtlc.com.mx>
 * date 22/01/2024
 * update 08/02/2024
 * desc Custom JavaScript
 */

// redirectOnChange for resources\views\shared\table-compare\select-actions.blade.php
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

/*****************************************************
 * Functions for `Archivos De Balanza De Comprobación`
 * @created 09/02/2024
 * @usage resources\views\vendor\backpack\crud\buttons\comparar_balanza.blade.php
 * @usage resources\views\vendor\backpack\crud\buttons\generar_sumarias.blade.php
 * @usage resources\views\materialidad\periods-table.blade.php
 *****************************************************/
function fncValidateBalance(idBefore, idAfter, generate = false) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/admin/validate-balances/' + idBefore + '/' + idAfter + '/' + generate,
            type: 'GET',
            success: function (result) {
                // Show a success notification bubble
                new Noty({
                    type: "success",
                    text: "<strong>Comparando balanzas</strong><br>Balanzas seleccionadas correctamente, comparando balanzas, espere..."
                }).show();

                resolve(result);
            },
            error: function (result) {
                const { responseJSON } = result;
                const errorMessage = responseJSON && responseJSON.message ? responseJSON.message : 'Error desconocido';

                // Show an error alert
                new Noty({
                    type: "danger",
                    text: "<strong>Error al comparar balanzas</strong><br/>" + errorMessage + "<br>"
                }).show();

                reject(result);
            }
        });
    });
}

/*****************************************************
 * Functions for `Archivos De Balanza De Comprobación`
 * @created 09/02/2024
 * @usage resources\views\vendor\backpack\crud\buttons\comparar_balanza.blade.php
 * @usage resources\views\vendor\backpack\crud\buttons\generar_sumarias.blade.php
 * @usage resources\views\materialidad\periods-table.blade.php
 *****************************************************/
function fncValidateTwoBalanzas(balanzaIdNo1, balanzaIdNo2, generate = false) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '/admin/validar-dos-balanza/' + balanzaIdNo1 + '/' + balanzaIdNo2 + '/' + generate,
            type: 'GET',
            success: function (result) {
                // Show a success notification bubble
                new Noty({
                    type: "success",
                    text: "<strong>Comparando balanzas</strong><br>Balanzas seleccionadas correctamente, comparando balanzas, espere..."
                }).show();

                resolve(result);
            },
            error: function (result) {
                const { responseJSON } = result;
                const errorMessage = responseJSON && responseJSON.message ? responseJSON.message : 'Error desconocido';

                // Show an error alert
                new Noty({
                    type: "danger",
                    text: "<strong>Error al comparar balanzas</strong><br/>" + errorMessage + "<br>"
                }).show();

                reject(result);
            }
        });
    });
}

/*****************************************************
 * Functions for `Matriz de Riesgo`
 * @created 29/01/2024
 * @usage resources\views\balances\matriz_de_riesgo\data_script.blade.php
 *****************************************************/

function getTotalActivoFijo(financialData) {
    const start = 0, end = 10;
    const sum_auditoria = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_auditoria || 0), 0);
    const sum_anterior = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_anterior || 0), 0);

    financialData[end].monto_anterior = sum_anterior;
    financialData[end].monto_auditoria = sum_auditoria;

    financialData.slice(start, end).forEach(item => {
        const porcentaje = (parseFloat(item.monto_auditoria || 0) / sum_auditoria) * 100;
        item.porcentaje = porcentaje.toFixed(2); // Ajustar el porcentaje a dos decimales
    });
}

function getTotalPasivo(financialData) {
    const start = 11, end = 18;
    const sum_auditoria = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_auditoria || 0), 0);
    const sum_anterior = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_anterior || 0), 0);

    financialData[end].monto_anterior = sum_anterior;
    financialData[end].monto_auditoria = sum_auditoria;

    financialData.slice(start, end).forEach(item => {
        const porcentaje = (parseFloat(item.monto_auditoria || 0) / sum_auditoria) * 100;
        item.porcentaje = porcentaje.toFixed(2); // Ajustar el porcentaje a dos decimales
    });
}

function getTotalCapitalContable(financialData) {
    const start = 19, end = 22;
    const sum_auditoria = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_auditoria || 0), 0);
    const sum_anterior = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_anterior || 0), 0);

    financialData[end].monto_anterior = sum_anterior;
    financialData[end].monto_auditoria = sum_auditoria;

    financialData.slice(start, end).forEach(item => {
        const porcentaje = (parseFloat(item.monto_auditoria || 0) / sum_auditoria) * 100;
        item.porcentaje = porcentaje.toFixed(2); // Ajustar el porcentaje a dos decimales
    });
}

function getTotal(financialData) {
    const start = 23, end = 29;
    const sum_auditoria = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_auditoria || 0), 0);
    const sum_anterior = financialData.slice(start, end)
        .reduce((total, item) => total + parseFloat(item.monto_anterior || 0), 0);

    financialData[end].monto_anterior = sum_anterior;
    financialData[end].monto_auditoria = sum_auditoria;

    financialData.slice(start, end).forEach(item => {
        const porcentaje = (parseFloat(item.monto_auditoria || 0) / sum_auditoria) * 100;
        item.porcentaje = porcentaje.toFixed(2); // Ajustar el porcentaje a dos decimales
    });
}


/*****************************************************
 * Functions for `Mapeo Balanza`
 * @created 08/02/2024
 * @usage resources\views\mapeo\mapeo.blade.php
 *****************************************************/

function getOptionsMapeoBalanza(grupo = '', valor = '') {
    let options = [];
    // Filtrar los elementos una vez
    let filteredIndices = [];
    if (grupo === 'activos') {
        filteredIndices = indices_filtrado.activos;
    } else if (grupo === 'pasivo_capital') {
        filteredIndices = indices_filtrado.pasivo_capital
    } else if (grupo.includes('resultados')) {
        filteredIndices = indices_filtrado.resultados
    } else {
        filteredIndices = indices_filtrado.default;
    }
    // Mapear los elementos filtrados a opciones HTML
    options = filteredIndices.map(letter =>
        `<option ${valor == letter.indice ? 'selected' : ''} data-descripcion="${letter.documento}" value="${letter.indice}">
        ${letter.indice} : ${letter.documento}</option>`).join('');
    return options;
}

function changeIndiceInRowVal(group_defualt, indice_default) {
    const options = getOptionsMapeoBalanza(group_defualt, indice_default);
    return options;
}

function changeIndiceInRow(slt) {
    var sltGrupo = $(slt).val();
    const options = getOptionsMapeoBalanza(sltGrupo);

    // Empty select to `slt_indice` on DataTable
    var selectElementInRow = $(slt).closest('tr').find('select[name="indice"]');
    selectElementInRow.empty();

    // Append new options to `slt_indice` on DataTable
    selectElementInRow.append(options);
}

function changeIndiceInCol(slt) {
    var sltGrupo = $(slt).val();
    const options = getOptionsMapeoBalanza(sltGrupo);

    // Empty select to `slt_indice` on advanced filter
    var slt_indice = $('#slt_indice');
    slt_indice.empty();

    // Append new options to `slt_indice` on advanced filter
    slt_indice.append(options);
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function createSelectColumn(name, dataField, options) {
    var selectOptions = options.map(function (option) {
        if (option === 'contable') {
            return `<option value="contable">${capitalizeFirstLetter('si')}</option>`;
        } else
            if (option === 'no_contable') {
                return `<option value="no_contable">${capitalizeFirstLetter('no')}</option>`;
            } else {
                return `<option value="${option}">${capitalizeFirstLetter(option)}</option>`;
            }
    }).join('');

    var selectHtml = `<div class="form-group">
                        <select name="${name}" class="form-control" style="width:100%" onchange="changeIndiceInRow(this)">
                            ${selectOptions}
                        </select>
                    </div>`;

    const slt = $('#slt_' + name);
    slt.append(selectOptions);

    return {
        targets: -1,
        data: dataField,
        render: function (data, type, full, meta) {
            var selectedValue = data === null ? options[1] : data;
            return selectHtml.replace(`value="${selectedValue}"`, `value="${selectedValue}" selected`);
        },
    };
}

/*****************************************************
 * Functions for `Archivos De Balanza De Comprobación`
 * @created 09/02/2024
 * @usage resources\views\vendor\backpack\crud\buttons\comparar_balanza.blade.php
 * @usage resources\views\vendor\backpack\crud\buttons\generar_sumarias.blade.php
 * @usage resources\views\shared\custom\balance\checkbox-name.blade.php
 *****************************************************/

function onChangeInputCheckBox(submit = false) {
    const ids = document.querySelectorAll(".compare-value-check:checked");
    const buttonGenerarSumarias = document.querySelector("#buttonGenerarSumarias");
    const buttonCompararBalanza = document.querySelector("#buttonCompararBalanza");

    buttonGenerarSumarias.disabled = buttonCompararBalanza.disabled = ids.length !== 2;
}

/*****************************************************
 * Functions for `Mapeo Por Balanza`
 * @created 12/02/2024
 * @usage resources\views\mapeo\mapeo.blade.php
 *****************************************************/
function enterAdvancedSearch(index = 1, cadena = '') {
    var subcadena = cadena.slice(1);
    //console.log(cadena, subcadena);
    table
        .columns().search('')
        .column(index).search(subcadena).draw();

    // Esperar al evento 'draw.dt' y filtrar por columna
    $('#tableMapeo tbody tr').each(function () {
        var valorColumna = $(this).find('td:eq(' + index + ')').text();
        var filtro = cadena.charAt(0);
        console.log(filtro, valorColumna);

        if (filtro === '*') {
            if (valorColumna.endsWith(subcadena)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        } else if (filtro === '.') {
            if (valorColumna.startsWith(subcadena)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        }
    });
}

function resetAdvancedSearch(index, cadena) {
    table
        .columns().search('')
        .column(index).search(cadena).draw();

    $('#tableMapeo tbody tr').each(function () {
        $(this).show();
    });
}


/*****************************************************
 * The function `triggerCuadrarCuentasEnRepeteable` calculates the total values of input fields with
 * class `el-cargo` and `el-abono`, compares them, and shows a success or danger message based on the
 * comparison.
 * @created 12/02/2024
 * @usage AjustarCuentaCrudController
 * @usage ReclasificarCuentaCrudController
 *****************************************************/
function triggerCuadrarCuentasEnRepeteable() {
    var inputs_cargo = document.querySelectorAll('input[type="number"].el-cargo');
    var total_cargo = 0;

    inputs_cargo.forEach(function (input) {
        var value = parseFloat(input.value) || 0;
        total_cargo += value;
    });

    var inputs_abono = document.querySelectorAll('input[type="number"].el-abono');
    var total_abono = 0;

    inputs_abono.forEach(function (input) {
        var value = parseFloat(input.value) || 0;
        total_abono += value;
    });

    console.log('Total de cargo ajustado: ', total_cargo);
    console.log('Total de abono ajustado: ', total_abono);
    if (total_abono == total_cargo) {
        document.querySelectorAll('#success-cuadrar-cuenta')[0].removeAttribute('hidden');
        document.querySelectorAll('#danger-cuadrar-cuenta')[0].setAttribute('hidden', '');
    } else {
        document.querySelectorAll('#danger-cuadrar-cuenta')[0].removeAttribute('hidden');
        document.querySelectorAll('#success-cuadrar-cuenta')[0].setAttribute('hidden', '');
    }
}

/**
 * The function `fncDownloadFile` initiates the automatic download of a file from a specified URL with
 * a given file name.
 * @param [file_url] - The `file_url` parameter is the URL of the file that you want to download. It
 * should be a valid URL pointing to the location of the file on the internet.
 * @param [file_name] - The `file_name` parameter in the `fncDownloadFile` function is used to specify
 * the name under which the file will be downloaded by the browser. This parameter allows you to set a
 * custom name for the downloaded file instead of using the original file name from the URL.
 * @created 28/08/2024
 * @usage resources\views\audfk\estados_financieros\web\one_balance_v3.blade.php
 */
function fncDownloadFile(file_url = '', file_name = '') {
    // Iniciar la descarga automática del archivo
    var link = document.createElement('a');
    link.href = file_url;
    link.download = file_name;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


/**
 * The function `handleOnChangeSelectColumnMulticolor` changes the background color of a select element
 * based on the selected value.
 * @created 19/09/2024
 * @usage resources\views\audfk\matriz_de_riesgo\web\two_balance_v3.blade.php
 */
function handleOnChangeSelectColumnMulticolor() {
    var selectedValue = $(this).val();
    $(this).removeClass('text-white bg-red bg-green bg-yellow');

    switch (selectedValue) {
        case 'si':
        case 'A':
            $(this).addClass('bg-red pointer text-white');
            break;
        case 'no':
        case 'B':
            $(this).addClass('bg-green pointer text-white');
            break;
        case 'M':
            $(this).addClass('bg-yellow pointer text-white');
            break;
        default:
            $(this).addClass('bg-red pointer text-white');
            break;
    }
}

/**
 * The function `createSelectColumnMulticolor` generates a custom select dropdown with multicolor
 * options based on the provided data and options.
 * @param name - The `name` parameter is the name attribute for the select element that will be
 * generated. It is used to identify the select element when the form is submitted or when interacting
 * with it using JavaScript.
 * @param dataField - The `dataField` parameter in the `createSelectColumnMulticolor` function
 * represents the field in the data source that will be used for this select column. It is the data
 * field that will be bound to the select element in the table. This field will determine the initial
 * value of the select element
 * @param options - The `options` parameter in the `createSelectColumnMulticolor` function is an array
 * containing the different options that will be displayed in the select dropdown. Each option will be
 * styled differently based on its value according to the switch case statements in the function.
 * @returns The `createSelectColumnMulticolor` function returns an object with three properties:
 * `data`, `render`, and `createdCell`.
 * @created 19/09/2024
 * @usage resources\views\audfk\matriz_de_riesgo\web\two_balance_v3.blade.php
 */
function createSelectColumnMulticolor(name, dataField, options) {
    var selectOptions = options.map(function (option, index) {
        let htmlOption = `<option value="${option}">${option}</option>`;
        switch (option) {
            case 'si':
            case 'A':
                htmlOption = `<option value="${option}" class="bg-red text-white pointer">${option}</option>`;
                break;
            case 'no':
            case 'B':
                htmlOption = `<option value="${option}"  class="bg-green text-white pointer">${option}</option>`;
                break;
            case 'M':
                htmlOption = `<option value="${option}"  class="bg-yellow text-white pointer">${option}</option>`;
                break;
            default:
                htmlOption = `<option value="${option}"  class="pointer">${option}</option>`;
                break;
        }
        return htmlOption;
    }).join('');

    var selectHtml = `<div class="form-group">
                        <select name="${name}" class="form-control select-multicolor">
                            ${selectOptions}
                        </select>
                    </div>`;

    return {
        data: dataField,
        render: function (data, type, full, meta) {
            var selectedValue = data === null ? options[0] : data;
            return selectHtml.replace(`value="${selectedValue}"`, `value="${selectedValue}" selected`);
        },
        createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            // Agregar el evento change al selector recién creado
            $(cell).find('.select-multicolor').change(handleOnChangeSelectColumnMulticolor);
        }
    };
}
