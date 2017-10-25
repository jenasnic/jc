
/**
 * JS script used in BO to edit a quizz => see view jcQuizzBundle:BO:editQuizz.html.twig
 */

$(document).ready(function() {

    // Define action when user add new response => display form as popup...
    $('#add-response-button').on('click', function() {
        editResponse($('#quizz-id').val(), 0);
    });

    loadResponseForQuizz();
});

/**
 * This methode is used to (re)load responses linked to current quizz.
 */
function loadResponseForQuizz() {

    var quizzId = $('#quizz-id').val();

    var ajaxBaseUrl = global.basePath + '/admin/quizz/' + quizzId + '/response/list';

    $.ajax({
        url: ajaxBaseUrl,
        type: 'GET',
        timeout: 10000,
        success: function(response) {

            $('#quizz-responses-list').html(response);
            defineActionForResponses();
        },
        error: function(msg) {
            alert("Impossible de charger les réponses");
        }
    });
}

/**
 * This methode is used to define action for responses using Ajax => edit and delete.
 */
function defineActionForResponses() {

    $('#response-list img.edit-response').each(function() {

        $(this).on('click', function() {

            var quizzId = $('#quizz-id').val();
            var rowToEdit = $(this).parent().parent();
            var responseId = rowToEdit.attr('data-id');

            editResponse(quizzId, responseId);
        });
    })

    $('#response-list img.delete-response').each(function() {
        $(this).on('click', function() {
            deleteResponse($(this));
        });
    })
}

/**
 * Allows to edit response from quizz using popup and Ajax.
 * @param quizzId Identifier of quizz linked to response we want to edit.
 * @param responseId Identifier of response to edit.
 */
function editResponse(quizzId, responseId) {

    var ajaxBaseUrl = global.basePath + '/admin/quizz/' + quizzId + '/response/edit/' + responseId;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'GET',
        timeout: 10000,
        success: function(response) {

            // Get form / init action / display as popup
            $('#quizz-response-popup').html(response);
            initSubmitResponseForm();
            $('#quizz-response-popup').bPopup();
        },
        error: function(msg) {
            alert("Impossible de modifier la réponse");
        }
    });
}

/**
 * Allows to remove response from quizz.
 * @param button Cliqued JQuery element (used to identify response and row to remove).
 */
function deleteResponse(button) {

    if (confirm('Confirmer la suppression ?')) {

        var quizzId = $('#quizz-id').val();

        var rowToDelete = $(button).parent().parent();
        var responseId = rowToDelete.attr('data-id');

        var ajaxBaseUrl = global.basePath + '/admin/quizz/' + quizzId + '/response/delete';

        $.ajax({
            url: ajaxBaseUrl,
            type: 'POST',
            data: {id: responseId},
            timeout: 10000,
            success: function(response) {

                // In case of success => remove row
                if (response.success)
                    rowToDelete.remove();
                else
                    alert(response.message);
            },
            error: function(msg) {
                alert("Impossible de supprimer la réponse");
            }
        });
    }
}

/**
 * Allows to define action when user submit response form (as Popup) => Ajax submit...
 */
function initSubmitResponseForm() {

    $("#quizz-response-form").submit(function(event){

        global.cancelEvent(event);

        var ajaxBaseUrl = $("#quizz-response-form").attr('action');
        var formSerialize = $("#quizz-response-form").serialize();

        $.ajax({
            url: ajaxBaseUrl,
            type: 'POST',
            data: formSerialize,
            timeout: 10000,
            success: function(response) {

                // In case of success => close popup
                if (response.success) {

                    $('#quizz-response-popup').bPopup().close();
                    loadResponseForQuizz();
                }
                else
                    alert(response.message);
            },
            error: function(msg) {
                alert("Impossible de modifier la réponse");
            }
        });
    });
}
