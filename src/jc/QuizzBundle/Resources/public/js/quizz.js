
/**
 * Script to process quizz, i.e. find response... => used in view FO:quizz.html.twig
 */

var tricking = false;

$(document).ready(function() {

    // Init picture for quizz (with zoom)
    $('#quizz').zoom({on:'grab'});

    // Define action when user send response
    $('#answer').on('click', function() {
        processAnswer();
    });

    // Define action when user want to display all response
    $('#display-all-answer').on('click', function() {
        displayAllResponses();
    });

    // Define action when user requires trick
    $('#process-trick').on('click', function() {
        processTrick();
    });

    $('#response').on('keypress', function(e) {
        if (e.keyCode == 13)
            processAnswer();
    });

    var el = document.querySelector('#response-list');
    SimpleScrollbar.initEl(el);

    $('#winner-form span.button').on('click', function() {
        submitWinnerForm();
    });
});

/**
 * Function called when user submit response.
 * It allows to check response and to display it in case of success.
 */
function processAnswer() {

    // Get data to send for checking answer
    var quizzId = $('#quizzId').val();
    var response = $('#response').val();

    if (response.length > 0) {

        // Send AJAX request
        var ajaxBaseUrl = global.basePath + '/quizz/ask';

        $.ajax({
            url: ajaxBaseUrl,
            type: 'POST',
            data: {quizzId: quizzId, response: response},
            timeout: 10000,
            success: function(response) {

                // In case of success => add response...
                if (response.success) {
                    processResponse(response);
                }
                else {

                    $('#quizz-popup').html(response.message);
                    $('#quizz-popup').bPopup({autoClose: 1000});
                }
            },
            error: function(msg) {
                alert("Impossible de vérifier la réponse");
            }
        });
    }
}

/**
 * Allows to process JSON response => check and add it if needed.
 * @param response Response as JSON array with id, title, positionX, positionY and size.
 */
function processResponse(response) {

    // If response already found => display appropriate response
    if ($('#quizz-movie-' + response.id).length) {

        $('#quizz-popup').html('Déjà trouvé !!!');
        $('#quizz-popup').bPopup({autoClose: 1000});
    }
    // Else add response to list and check if quizz completed
    else {

        addResponse(response.id, response.title, response.positionX, response.positionY, response.size);

        var winningCount = $('#quizzCount').val();

        if ($('#response-list .ss-content li').length == winningCount) {

            $('#quizz-answer').hide();
            $('#quizz-info').hide();
            $('#quizz-popup').html('<h2>Félicitations !!!</h2>Vous avez trouvé les ' + winningCount + ' films.');
            $('#quizz-popup').bPopup({autoClose: 2000});

            // Display form to register
            $('#winner-form').show();
        }
        else {

            $('#response-count').html($('#response-list .ss-content li').length);
            $('#quizz-popup').html('Bravo !!!');
            $('#quizz-popup').bPopup({autoClose: 1000});
            $('#response').val('');
        }
    }
}

/**
 * Allows to add response on quizz with appropriate actions.
 * @param id Quizz identifier we are searching for answers.
 * @param movie Movie's title found.
 * @param positionX X coordonate for picture used to locate answer on quizz's picture.
 * @param positionY Y coordonate for picture used to locate answer on quizz's picture.
 * @param pictureSize Picture used to locate answer on quizz's picture.
 */
function addResponse(id, movie, positionX, positionY, pictureSize) {

    // Add response to list + picture to locate movie
    $('#response-list .ss-content').prepend('<li id="quizz-movie-' + id + '">' + movie + '</li>');

    // If quizz require to display response
    if ($('#displayResponse').val() == 1) {

        // Add picture to locate movie
        $('#quizz').append('<div id="quizz-picture-' + id + '" class="quizz-picture quizz-picture-size-' + pictureSize + '" style="left:' + positionX + 'px;top:' + positionY + 'px;"></div>')

        // Display/hide movie reference on picture when user select response
        $('#quizz-movie-' + id).on('mouseover', function() {$('#quizz-picture-' + id).show();});
        $('#quizz-movie-' + id).on('mouseout', function() {$('#quizz-picture-' + id).hide();});
    }
}

/**
 * Allows to submit winner form when user has found all responses.
 */
function submitWinnerForm() {

    // Send AJAX request
    var ajaxBaseUrl = global.basePath + '/quizz/win/' + $('#quizzId').val();

    // Get all responses found
    var responses = '';
    $('#response-list li').each(function(index, element) {
        responses = responses + ';' + $(element).html();
    });

    // Remove first ';' if needed
    if (responses.length > 0)
        responses = responses.substring(1);

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        data: {name: $('#name').val(), mail: $('#mail').val(), comment:$('#comment').val(), responses: responses},
        timeout: 10000,
        success: function(response) {

            $('#quizz-popup').html(response.message);
            $('#quizz-popup').bPopup({autoClose: 1000});

            if (response.success)
                $('#winner-form').hide();
        },
        error: function(msg) {
            alert("Impossible de vous enregistrer");
        }
    });
}

/**
 * Allows to display all responses (for logged user only).
 */
function displayAllResponses() {

    // Send AJAX request
    var ajaxBaseUrl = global.basePath + '/quizz/responses/' + $('#quizzId').val();

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        timeout: 10000,
        success: function(response) {

            if (response.success) {

                var responseList = response.responses;

                // Browse responses and display them if needed
                for (var i=0; i<responseList.length; i++)
                    processResponse(responseList[i]);
            }
            else
                alert(response.message);
        },
        error: function(msg) {
            alert("Impossible d'afficher les réponses");
        }
    });
}

function processTrick() {

    // If user already ask a trick => cancel operation
    if (tricking) {

        // Restore cursor for picture and re-activate zoom
        $('#quizz').unbind('click');
        $('#quizz').css('cursor', 'zoom-in');
        $('#quizz').zoom({on:'grab'});

        $('#require-trick').val('Demander un indice');
        tricking = false;

        return false;
    }

    tricking = true;
    $('#require-trick').val("Annuler l'indice");

    // Remove zoom and change cursor for picture...
    $('#quizz').trigger('zoom.destroy');
    $('#quizz').css('cursor', 'help');

    // Add action on quizz click
    $('#quizz').on('click', function(e) {
        requestTrick(e.offsetX, e.offsetY);
    });
}

function requestTrick(positionX, positionY) {

    // Send AJAX request
    var ajaxBaseUrl = global.basePath + '/quizz/trick';
    var quizzId = $('#quizzId').val();

    dump(positionX + ' // ' + positionY + ' // ' + quizzId);

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        timeout: 10000,
        data: {quizzId: quizzId, positionX: positionX, positionY: positionY},
        success: function(response) {

            if (response.success) {

                var responseList = response.trick;
                dump(responseList);

                var message = responseList.length + ' film(s) à trouver :<br/><br/><ul>'
                // Browse responses and display them if needed
                for (var i=0; i<responseList.length; i++)
                    message += '<li>' + responseList[i].title + '</li>';

                message += '</ul>';

                $('#quizz-popup').html(message);
                $('#quizz-popup').bPopup({
                    onClose: function() {
                        processTrick();
                    }
                });

            }
            else
                alert(response.message);
        },
        error: function(msg) {
            alert("Impossible d'afficher les indices");
        }
    });
}

