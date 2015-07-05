
$(document).ready(function() {

    // Set initial input values read only
    $('td.type-1 input').prop("readonly", true);

    // Restrict input values for sudoku (1 to 9)
    $(".sudoku input").numeric({
        allowMinus: false,
        allowThouSep: false,
        allowDecSep: false,
        maxDigits: 1,
        max: 9,
        min: 0
    });
});