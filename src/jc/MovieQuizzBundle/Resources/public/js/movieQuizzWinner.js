
/**
 * JS script used in BO to list winners for a quizz => see view jcMovieQuizzBundle:BO:listWinner.html.twig
 */

$(document).ready(function() {

    $('#movie-quizz-winner-list a.detail').on('click', function(e) {

        global.cancelEvent(e)

        var mail = $(this).children('span.movie-quizz-winner-mail').html();
        var comment = $(this).children('span.movie-quizz-winner-comment').html();
        var trickCount = $(this).children('span.movie-quizz-winner-trick-count').html();

        $('#movie-quizz-winner-detail-popup span.movie-quizz-winner-mail').html(mail);
        $('#movie-quizz-winner-detail-popup span.movie-quizz-winner-comment').html(comment);
        $('#movie-quizz-winner-detail-popup span.movie-quizz-winner-trick-count').html(trickCount);
        $('#movie-quizz-winner-detail-popup').bPopup();
    });
});
