
var wysiwygInitialized = false;

$(document).ready(function() {

    // Define action when user add comment => display form
    $('#add-comment-button').on('click', function() {

        $('#add-comment-form').show();

        // If  not yet initialized => initialize WYSIWYG
        if (!wysiwygInitialized) {

            $('#add-comment-form textarea').cleditor({
                controls: "bold italic underline strikethrough | font size color",
                height: '120'
            });
        }

        $('#add-comment-button').hide();
    });

    // Define action when user add comment => validate action
    $('#add-comment-form input[type="button"]').on('click', function() {

        $('#add-comment-form input[type="button"]').prop('disabled', true);
        postComment();
    });

    // Define action when user delete comment
    $('.delete-comment-button').on('click', function() {
        if (confirm('Confirmer la suppression ?'))
            deleteComment($(this));
    });
});

function postComment() {

    var trainingSessionId = $('#add-comment-form input[type="hidden"]').val();
    var comment = $('#add-comment-form textarea').val()

    // Post comment using ajax and display it
    var ajaxBaseUrl = global.basePath + '/user/ajax/trainingSession/comment/edit/' + trainingSessionId;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        data: {comment: comment},
        timeout: 10000,
        success: function(msg) {

            $('#add-comment-form').after(msg);

            // Clear comment content in textarea
            $('#add-comment-form textarea').val('');
            $('#add-comment-form textarea').blur();

            // Init suppression event on new comment
            $('#add-comment-form').next().children('.delete-comment-button').on('click', function() {
                if (confirm('Confirmer la suppression ?'))
                    deleteComment($(this));
            });
        },
        error: function(msg) {
            alert("Impossible d'ajouter votre commentaire");
        },
        complete: function() {

            $('#add-comment-form').hide();
            $('#add-comment-form input[type="button"]').prop('disabled', false);
            $('#add-comment-button').show();
        }
    });
}

function deleteComment(commentButton) {

    var commentId = $(commentButton).attr('comment-id');

    // Post comment using ajax and display it
    var ajaxBaseUrl = global.basePath + '/user/ajax/trainingSession/comment/delete/' + commentId;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        timeout: 10000,
        success: function(msg) {
            $(commentButton).parent().remove();
        },
        error: function(msg) {
            alert("Impossible de supprimer le commentaire : " + msg);
        }
    });
}
