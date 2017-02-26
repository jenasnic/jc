
$(document).ready(function() {

    // Init picture for quizz (with zoom)
    $('#quizz').zoom({on:'grab'});

    // Define action when user send response
    $('#answer').on('click', function() {
        processAnswer();
    });

    $('#response').on('keypress', function(e) {
        if (e.keyCode == 13)
            processAnswer();
    });

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
