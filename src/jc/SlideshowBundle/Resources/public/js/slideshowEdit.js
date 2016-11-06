
$(document).ready(function() {

    // Apply JQuery UI functionnality : picture list sortable + calendar 
    $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
    $('#picture-list').sortable({
        update: function(event, ui) {updatePicturesRank();}
    });

    // Use dropzone to upload slideshow's pictures
    $('#slideshow-dropzone').dropzone({
        sending: function(file, xhr, formData) {formData.append('slideshowId', $('#slideshow-id').val());},
        success: function(file, response) {addFileToList(file, response);}
    });

    // Define action when user remove picture from list
    $('#picture-list .delete-picture').on('click', function() {deletePicture($(this));});
});

/**
 * This methode is called after picture upload succeed. It allows to update picture list adding new uploaded picture.
 * @param file Uploaded file.
 * @param response Response from upload methode called.
 */
function addFileToList(file, response) {

    if (response.success) {

        // Create new row for specified file
        var row = $('#row-template tbody tr').clone();

        var inputId = row.find('input.picture-id');
        var inputRank = row.find('input.picture-rank');
        var inputName = row.find('input.picture-name');
        var pictureItem = row.find('td.bo-table-picture img');

        // Update fields values
        inputId.val(response.id);
        inputRank.val(response.rank);
        inputName.val(response.name);
        pictureItem.attr("src", response.url);

        // Set id/name for POST (when submitting form)
        inputId.attr("id", "picture-id-" + response.id);
        inputId.attr("name", "picture-id-" + response.id);
        inputRank.attr("id", "picture-rank-" + response.id);
        inputRank.attr("name", "picture-rank-" + response.id);
        inputName.attr("id", "picture-name-" + response.id);
        inputName.attr("name", "picture-name-" + response.id);

        // Add event for remove button
        row.find('.delete-picture').on('click', function() {deletePicture($(this));})
        $('#picture-list').append(row);
    }
    else
        alert(response.message);
}

/**
 * Allows to remove picture from slideshow.
 * @param button Cliqued JQuery element (used to identify picture and row to remove).
 */
function deletePicture(button) {

    if (confirm('Confirmer la suppression ?')) {

        var rowToDelete = $(button).parent().parent();
        var pictureId = rowToDelete.find('input.picture-id').val();

        var ajaxBaseUrl = global.basePath + '/admin/slideshow/picture/delete';

        $.ajax({
            url: ajaxBaseUrl,
            type: 'POST',
            data: {pictureId: pictureId},
            timeout: 10000,
            success: function(response) {

                // In case of success => remove row
                if (response.success)
                    rowToDelete.remove();
                else
                    alert(response.message);
            },
            error: function(msg) {
                alert("Impossible de supprimer l'image");
            }
        });
    }
}

/**
 * Allows to update rank field for pictures (after user change sort...).
 */
function updatePicturesRank() {

    // Get all pictures to set rank
    var pictureList = $("#picture-list").children("tr");

    for (var i=0; i<pictureList.length; i++)
        $(pictureList[i]).find(".picture-rank").val(i+1);
}
