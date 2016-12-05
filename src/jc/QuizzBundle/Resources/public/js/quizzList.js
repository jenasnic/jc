
$(document).ready(function() {

    $('#create-quizz-button').on('click', function() {

        // Clear field + display popup to create slideshow (enter name) and focus field
        $('#create-quizz-popup input[type="text"]').val('');
        $('#create-quizz-popup').bPopup();
        $('#create-quizz-popup input[type="text"]').focus();
    });

    $('#create-quizz-popup span').on('click', function() {

        var name = $('#create-quizz-popup input[type="text"]').val();
        createQuizz(name);
    });
});

function createQuizz(name) {

    var ajaxBaseUrl = global.basePath + '/admin/quizz/create';

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
                $('#create-quizz-popup').bPopup().close();
            }
        },
        error: function(msg) {
            alert("Impossible de créer le quizz");
            $('#create-quizz-popup').bPopup().close();
        }
    });
}
