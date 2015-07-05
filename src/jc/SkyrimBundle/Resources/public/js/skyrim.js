
$(document).ready(function() {

    $('#alchemy-ingredient li').on('click', function() {
        reloadAlchemyContent('ingredient', $(this).attr('data-id'));
    });
    $('#alchemy-effect li').on('click', function() {
        reloadAlchemyContent('effect', $(this).attr('data-id'));
    });
});

/**
 * Allows to reload alchemy content for specified item.
 * @param type Type of item (ingredient or effect).
 * @param id Identifier of item.
 */
function reloadAlchemyContent(type, id) {

    var ajaxBaseUrl = global.basePath + '/ajax/skyrim/alchemy/' + type + '/' + id;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        timeout: 10000,
        success: function(msg) {
            $('#alchemy-result').html(msg);
        },
        error: function(msg) {
            alert("Impossible de charger le contenu du dossier");
            $('#alchemy-result').html("Erreur");
        }
    });
}
