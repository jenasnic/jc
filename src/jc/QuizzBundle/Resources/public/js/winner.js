
/**
 * JS script used in BO to list winners for a quizz => see view jcQuizzBundle:BO:listWinner.html.twig
 */

$(document).ready(function() {

    $('#winner-list a.detail').on('click', function(e) {

        global.cancelEvent(e)

        var mail = $(this).children('span.winner-mail').html();
        var comment = $(this).children('span.winner-comment').html();
        var trickCount = $(this).children('span.winner-trick-count').html();

        $('#winner-detail-popup span.winner-mail').html(mail);
        $('#winner-detail-popup span.winner-comment').html(comment);
        $('#winner-detail-popup span.winner-trick-count').html(trickCount);
        $('#winner-detail-popup').bPopup();
    });
});
