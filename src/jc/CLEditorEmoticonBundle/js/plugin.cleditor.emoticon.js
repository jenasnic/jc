
(function($) {
 
    // Define the hello button
    $.cleditor.buttons.emoticon = {
        name: "emoticon",
        css: {"background": "url('/resources/css/images/smiley.png') no-repeat 5px 4px"},
        title: "Smiley",
        command: "inserthtml",
        popupName: "Smiley",
        popupClass: "cleditorEmoticon",
        popupContent: "<img src='/resources/images/emoticons/ack.gif' /><img src='/resources/images/emoticons/armed.gif' />"
            + "<img src='/resources/images/emoticons/badrazz.gif' /><img src='/resources/images/emoticons/bangin.gif' />"
            + "<img src='/resources/images/emoticons/biggrin.gif' /><img src='/resources/images/emoticons/blah.gif' />"
            + "<img src='/resources/images/emoticons/blueblob.gif' /><img src='/resources/images/emoticons/boogie.gif' />"
            + "<img src='/resources/images/emoticons/bump.gif' /><img src='/resources/images/emoticons/cheers.gif' />"
            + "<img src='/resources/images/emoticons/clap.gif' /><img src='/resources/images/emoticons/confused.gif' />"
            + "<img src='/resources/images/emoticons/cry.gif' /><img src='/resources/images/emoticons/drool.gif' />"
            + "<img src='/resources/images/emoticons/eek.gif' /><img src='/resources/images/emoticons/fight.gif' />"
            + "<img src='/resources/images/emoticons/flame.gif' /><img src='/resources/images/emoticons/huh.gif' />"
            + "<img src='/resources/images/emoticons/king.gif' /><img src='/resources/images/emoticons/lol.gif' />"
            + "<img src='/resources/images/emoticons/mecry.gif' /><img src='/resources/images/emoticons/nag.gif' />"
            + "<img src='/resources/images/emoticons/nuts.gif' /><img src='/resources/images/emoticons/rocker.gif' />"
            + "<img src='/resources/images/emoticons/rofl.gif' /><img src='/resources/images/emoticons/roller.gif' />"
            + "<img src='/resources/images/emoticons/spineyes.gif' /><img src='/resources/images/emoticons/tongue.gif' />"
            + "<img src='/resources/images/emoticons/wink.gif' /><img src='/resources/images/emoticons/zzz.gif' />",
        buttonClick: selectEmoticon
    };

    function selectEmoticon(e, data) {

        $(data.popup).find('img')
            .unbind('click')
            .bind('click', function() {
                data.editor.execCommand(data.command, '<img src="' + $(this).attr('src') + '" />');
                data.editor.hidePopups();
                data.editor.focus();
            });
    }
})(jQuery);
