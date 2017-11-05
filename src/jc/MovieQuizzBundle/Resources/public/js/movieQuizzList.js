
/**
 * JS script used in BO to list quizz (and create/edit quizz) => see view jcMovieQuizzBundle:BO:listQuizz.html.twig
 */

$(document).ready(function() {

    $('#create-movie-quizz-button').on('click', function() {

        // Clear field + display popup to create slideshow (enter name) and focus field
        $('#create-movie-quizz-popup input[type="text"]').val('');
        $('#create-movie-quizz-popup').bPopup();
        $('#create-movie-quizz-popup input[type="text"]').focus();
    });

    $('#create-movie-quizz-popup span').on('click', function() {

        var name = $('#create-movie-quizz-popup input[type="text"]').val();
        createQuizz(name);
    });
});

function createQuizz(name) {

    var ajaxBaseUrl = global.basePath + '/admin/movie-quizz/create';

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        data: {name: name},
        timeout: 10000,
        success: function(response) {

            // In case of success => redirect to slideshow
            if (response.success && response.redirectUrl)
                window.location = response.redirectUrl;
            else {

                alert(response.message);
                $('#create-movie-quizz-popup').bPopup().close();
            }
        },
        error: function(msg) {
            alert("Impossible de créer le quizz");
            $('#create-movie-quizz-popup').bPopup().close();
        }
    });
}
