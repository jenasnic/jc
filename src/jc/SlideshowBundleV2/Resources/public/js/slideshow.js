
$(document).ready(function() {

    $('#slideshow-list li').on('click', function() {
        reloadSlideshow($(this).attr('data-id'));
    });

    // Configure drop zone for upload
    Dropzone.options.userfileDropzone = {
        dictDefaultMessage: 'Déposez les images du diaporama...',
        autoProcessQueue: false,
        previewTemplate: global.dropzoneTemplate
    };
});

function reloadSlideshow(id) {

    var ajaxBaseUrl = global.basePath + '/ajax/slideshow/' + id;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        //data: {id: id},
        timeout: 10000,
        success: function(msg) {
            $('#slideshow-content').html(msg);
        },
        error: function(msg) {
            alert("Impossible de charger le diaporama");
            $('#slideshow-content').html("Erreur");
        }
    });
}
