
$(document).ready(function() {

    $('#winner-list a.detail').on('click', function(e) {
        
        global.cancelEvent(e)

        var mail = $(this).children('span.winner-mail').html();
        var comment = $(this).children('span.winner-comment').html();

        $('#winner-detail-popup span.winner-mail').html(mail);
        $('#winner-detail-popup span.winner-comment').html(comment);
        $('#winner-detail-popup').bPopup();
    });
});
