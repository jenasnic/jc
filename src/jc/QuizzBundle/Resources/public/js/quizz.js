
$(document).ready(function() {

    // Init picture for quizz (with zoom)
    $('#quizz').zoom({on:'grab'});

    // Define action when user send response
    $('#answer').on('click', function() {
        processAnswer();
    });

    $(document).on('keypress', function(e) {
        if (e.keyCode == 13)
            processAnswer();
    });
});

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

                    addResponse(response.id, response.title, response.positionX, response.positionY, response.size);

                    // Check if user has found all repsonses
                    checkQuizzOver();
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

function addResponse(id, movie, positionX, positionY, pictureSize) {

    // Check if reponse already found
    if ($('#quizz-movie-' + response.id).length && $('#quizz-picture-' + response.id).length) {

        $('#quizz-popup').html('Déjà trouvé !!!');
        $('#quizz-popup').bPopup({autoClose: 1000});
    }
    else {

        $('#quizz-popup').html('Bravo !!!');
        $('#quizz-popup').bPopup({autoClose: 1000});
        $('#response').val('');

        // Add response to list
        $('#response-list').prepend('<li id="quizz-movie-' + id + '">' + movie + '</li>');

        // If quizz require to display response
        if ($('#displayResponse').val() == 1) {

            // Add picture to locate movie
            $('#quizz').append('<div id="quizz-picture-' + id + '" class="quizz-picture quizz-picture-size-' + pictureSize + '" style="left:' + positionX + 'px;top:' + positionY + 'px;"></div>')

            // Display/hide movie reference on picture when user select response
            $('#quizz-movie-' + id).on('mouseover', function() {$('#quizz-picture-' + id).show();});
            $('#quizz-movie-' + id).on('mouseout', function() {$('#quizz-picture-' + id).hide();});
        }
    }
}

function checkQuizzOver() {

    var winningCount = $('#quizzCount').val();

    if ($('#response-list li').length == winningCount && $('#quizz div.quizz-picture').length == winningCount) {

        $('#quizz-answer').hide();
        $('#quizz-info').hide();
        $('#quizz-popup').html('<h2>Félicitations !!!</h2>Vous avez trouvé les ' + winningCount + ' films.');
        $('#quizz-popup').bPopup();
    }
    else
        $('#response-count').html($('#quizz div.quizz-picture').length);
}