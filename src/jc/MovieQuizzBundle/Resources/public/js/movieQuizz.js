
/**
 * Script to process quizz, i.e. find response... => see view jcMovieQuizzBundle:FO:quizz.html.twig
 */

var tricking = false;

$(document).ready(function() {

    // Init picture for quizz (with zoom)
    $('#movie-quizz').zoom({on:'grab'});

    // Define action when user send response
    $('#movie-quizz-answer').on('click', function() {
        processAnswer();
    });

    // Define action when user want to display all response
    $('#display-all-answer').on('click', function() {
        displayAllResponses();
    });

    // Define action when user requires trick
    $('#movie-quizz-require-trick').on('click', function() {
        processTrick();
    });

    $('#movie-quizz-response').on('keypress', function(e) {
        if (e.keyCode == 13)
            processAnswer();
    });

    // WARNING : Do not change two following lines !!!
    var el = document.querySelector('#movie-quizz-response-list');
    SimpleScrollbar.initEl(el);

    $('#movie-quizz-winner-form span.button').on('click', function() {
        submitWinnerForm();
    });
});

/**
 * Function called when user submit response.
 * It allows to check response and to display it in case of success.
 */
function processAnswer() {

    // Get data to send for checking answer
    var quizzId = $('#movie-quizz-id').val();
    var response = $('#movie-quizz-response').val();

    if (response.length > 0) {

        // Send AJAX request
        var ajaxBaseUrl = global.basePath + '/movie-quizz/ask';

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

                    $('#movie-quizz-popup').html(response.message);
                    $('#movie-quizz-popup').bPopup({autoClose: 1000});
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
    if ($('#movie-quizz-movie-' + response.id).length) {

        $('#movie-quizz-popup').html('Déjà trouvé !!!');
        $('#movie-quizz-popup').bPopup({autoClose: 1000});
    }
    // Else add response to list and check if quizz completed
    else {

        addResponse(response.id, response.title, response.positionX, response.positionY, response.size);

        var winningCount = $('#movie-quizz-count').val();

        if ($('#movie-quizz-response-list .ss-content li').length == winningCount) {

            $('#movie-quizz-answer').hide();
            $('#movie-quizz-info').hide();
            $('#movie-quizz-popup').html('<h2>Félicitations !!!</h2>Vous avez trouvé les ' + winningCount + ' films.');
            $('#movie-quizz-popup').bPopup({autoClose: 2000});

            // Display form to register
            $('#movie-quizz-winner-form').show();
        }
        else {

            $('#movie-quizz-response-count').html($('#movie-quizz-response-list .ss-content li').length);
            $('#movie-quizz-popup').html('Bravo !!!');
            $('#movie-quizz-popup').bPopup({autoClose: 1000});
            $('#movie-quizz-response').val('');
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
    $('#movie-quizz-response-list .ss-content').prepend('<li id="movie-quizz-movie-' + id + '">' + movie + '</li>');

    // If quizz require to display response
    if ($('#movie-quizz-display-response').val() == 1) {

        // Add picture to locate movie
        $('#movie-quizz').append('<div id="movie-quizz-picture-' + id + '" class="movie-quizz-picture movie-quizz-picture-size-' + pictureSize + '" style="left:' + positionX + 'px;top:' + positionY + 'px;"></div>')

        // Display/hide movie reference on picture when user select response
        $('#movie-quizz-movie-' + id).on('mouseover', function() {$('#movie-quizz-picture-' + id).show();});
        $('#movie-quizz-movie-' + id).on('mouseout', function() {$('#movie-quizz-picture-' + id).hide();});
    }
}

/**
 * Allows to submit winner form when user has found all responses.
 */
function submitWinnerForm() {

    // Send AJAX request
    var ajaxBaseUrl = global.basePath + '/movie-quizz/win/' + $('#movie-quizz-id').val();

    // Get all responses found
    var responses = '';
    $('#movie-quizz-response-list li').each(function(index, element) {
        responses = responses + ';' + $(element).html();
    });

    // Remove first ';' if needed
    if (responses.length > 0)
        responses = responses.substring(1);

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        data: {name: $('#name').val(), mail: $('#mail').val(), comment:$('#comment').val(), trickCount: $('#movie-quizz-trick-count').html(), responses: responses},
        timeout: 10000,
        success: function(response) {

            $('#movie-quizz-popup').html(response.message);
            $('#movie-quizz-popup').bPopup({autoClose: 1000});

            if (response.success)
                $('#movie-quizz-winner-form').hide();
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
    var ajaxBaseUrl = global.basePath + '/movie-quizz/responses/' + $('#movie-quizz-id').val();

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

/**
 * Allows user to ask a trick on picture to find a response.
 */
function processTrick() {

    // If user already ask a trick => cancel operation
    if (tricking) {

        // Restore cursor for picture and re-activate zoom
        $('#movie-quizz').unbind('click');
        $('#movie-quizz').css('cursor', 'zoom-in');
        $('#movie-quizz').zoom({on:'grab'});

        $('#movie-quizz-require-trick').removeClass('activ');
        $('#movie-quizz-require-trick').val('Demander un indice');
        tricking = false;

        return false;
    }

    tricking = true;
    $('#movie-quizz-require-trick').addClass('activ');
    $('#movie-quizz-require-trick').val("Annuler l'indice");

    // Remove zoom and change cursor for picture...
    $('#movie-quizz').trigger('zoom.destroy');
    $('#movie-quizz').css('cursor', 'help');

    // Add action on quizz click
    $('#movie-quizz').on('click', function(e) {

        // WARNING : check if offset between quizz container and picture
        var offsetQuizz = $('#movie-quizz').offset();
        var offsetPicture = $('#movie-quizz-picture').offset();
        var decalTop = offsetPicture.top - offsetQuizz.top;
        var decalLeft = offsetPicture.left - offsetQuizz.left;

        var positionX = e.offsetX;
        var positionY = e.offsetY;

        // If needed => adjust position to get trick...
        if (decalLeft > 1)
            positionX += decalLeft;
        if (decalTop > 1)
            positionY += decalTop;

        requestTrick(positionX, positionY);
    });
}

/**
 * Allows to launch AJAX call to find all responses matching specified area on quizz.
 * @param positionX Coordonate X of position we want to have a trick.
 * @param positionY Coordonate Y of position we want to have a trick.
 * @returns
 */
function requestTrick(positionX, positionY) {

    // Send AJAX request
    var ajaxBaseUrl = global.basePath + '/movie-quizz/trick';
    var quizzId = $('#movie-quizz-id').val();

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        timeout: 10000,
        data: {quizzId: quizzId, positionX: positionX, positionY: positionY},
        success: function(response) {

            if (response.success) {

                // Update trick count (to inform user + in winner form...)
                var trickCount = $('#movie-quizz-trick-count').html();
                $('#movie-quizz-trick-count').html(++trickCount);

                var responseList = response.trick;

                var message = responseList.length + ' film(s) à trouver ici :<br/><br/><ul>'
                // Browse responses and display them if needed
                for (var i=0; i<responseList.length; i++)
                    message += '<li>' + responseList[i].title + '</li>';

                message += '</ul>';

                $('#movie-quizz-popup').html(message);
                $('#movie-quizz-popup').bPopup({
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
