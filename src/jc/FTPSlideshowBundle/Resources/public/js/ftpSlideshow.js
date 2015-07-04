
$(document).ready(function() {

    $('#ftp-slideshow-list li').on('click', function() {
        reloadSlideshow($(this).attr('data-folder'));
    });
});

function reloadSlideshow(folder) {

    var ajaxBaseUrl = global.basePath + '/ajax/ftpSlideshow/' + folder;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        //data: {folder: folder},
        timeout: 10000,
        success: function(msg) {
            $('#ftp-slideshow-content').html(msg);
        },
        error: function(msg) {
            alert("Impossible de charger le diaporama");
            $('#ftp-slideshow-content').html("Erreur");
        }
    });
}
