
/**
 * Set belows values to adjust fullscreen icon depending on picture max size and container :
 *     - pictureMaxWidth : max width in CSS for picture in slideshow
 *     - pictureMaxHeight : max height in CSS for picture in slideshow
 *     - pictureContainerWidth : picture container width in CSS (can be greater than picture width)
 *     - pictureVerticalOffset : offset to adjust fullscreen icon vertically
 *     - pictureHorizontalOffset : offset to adjust fullscreen icon horizontally
 */
var pictureMaxWidth = 400;
var pictureMaxHeight = 400;
var pictureContainerWidth = 410;
var pictureVerticalOffset = 55;
var pictureHorizontalOffset = 5;

$(document).ready(function() {

    $('#slideshow-list li').on('click', function() {
        reloadSlideshow($(this).attr('data-id'));
    });

    $('#slideshow-list li').first().click();
});

function reloadSlideshow(id) {

    var ajaxBaseUrl = global.basePath + '/albums/' + id;

    $.ajax({
        url: ajaxBaseUrl,
        type: 'POST',
        //data: {id: id},
        timeout: 10000,
        success: function(msg) {
            $('#slideshow-content').html(msg);
            initSlideshow();
        },
        error: function(msg) {
            alert("Impossible de charger le diaporama");
            $('#slideshow-content').html("Erreur");
        }
    });
}

/**
 * Allows to initialize slideshow after reloading it through AJAX.
 */
function initSlideshow() {

    $('#picture-list').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        nextArrow: '<span class="slick-next">&gt;</span>',
        prevArrow: '<span class="slick-prev">&lt;</span>',
        slide : 'li',
        slidesToShow : 1
    });

    initFullScreenAction();
}

/**
 * Allows to initialize action and CSS to display picture fullscreen.
 */
function initFullScreenAction() {

    $('#picture-list img').each(function() {

        // Define action when user click on button
        $(this).on('click', function() {

            // Add css style (useful to keep border if exist)
            $('#slideshow-popup').attr('style', $(this).attr('style'));

            // Display full screen picture as popup
            $('#slideshow-popup').bPopup({
                content: 'image',
                loadUrl: $(this).attr('src')
            });

            // Close popup when clicking on picture
            // NOTE : Clear popup content to avoid multiple content when re-open...
            $('#slideshow-popup').on('click', function() {
                $('#slideshow-popup').bPopup().close();
                $('#slideshow-popup').html('');
            })

            return false;
        });

        // Display button depending on picture size
        // NOTE 1 : check picture container width/height
        // NOTE 2 : check picture border if exist
        var pictureSize = getPictureSize($(this), pictureMaxWidth, pictureMaxHeight);
        var fullscreenButton = $(this).next('span.picture-button');
        var topPosition = pictureSize.height - pictureVerticalOffset;
        var rightPosition = ((pictureContainerWidth - pictureSize.width) / 2) + pictureHorizontalOffset;
        $(fullscreenButton).css('top', topPosition);
        $(fullscreenButton).css('right', rightPosition);

        // Define action if user click => same as picture click
        $(fullscreenButton).on('click', function() {
            $(this).prev('img').click();
        });
    });
}

/**
 * Allows to calculate new picture size depending on specified max width/height
 * @param imgElement Element picture we want to calculate true size
 * @param maxWidth Maximum authorized width
 * @param maxHeight Maximum authorized height
 * @returns Size element with both properties width and height.
 */
function getPictureSize(imgElement, maxWidth, maxHeight) {

    var width = parseInt(imgElement.attr('data-width'));
    var height = parseInt(imgElement.attr('data-height'));

    // Check max width
    if (width > maxWidth) {

        height = Math.round((height * maxWidth) / width);
        width = maxWidth;
    }

    // Check max height
    if (height > maxHeight) {

        width = Math.round((width * maxHeight) / height);
        height = maxHeight;
    }

    return {width: width, height: height};
}
