
$(document).ready(function() {

    $('.zip-code').numeric({maxPreDecimalPlaces:5, maxDecimalPlaces:0, allowThouSep:false, allowMinus:false});

    var initialLatitude = $('#jc_trainingsessionbundle_location_latitude').val();
    var initialLongitude = $('#jc_trainingsessionbundle_location_longitude').val();
    var initialZoom = parseInt($('#jc_trainingsessionbundle_location_zoom option:selected').val());

    var helpPoint = new google.maps.LatLng(initialLatitude, initialLongitude);
    var helpMapOptions = {zoom:initialZoom, center: helpPoint, mapTypeId: google.maps.MapTypeId.ROADMAP};
    var helpMap = new google.maps.Map($('#help-map-content')[0], helpMapOptions);

    google.maps.event.addListener(helpMap, 'zoom_changed', function() {
        $('#jc_trainingsessionbundle_location_zoom').val(helpMap.getZoom());
    });
    google.maps.event.addListener(helpMap, 'center_changed', function() {
        $('#jc_trainingsessionbundle_location_latitude').val(helpMap.getCenter().lat());
        $('#jc_trainingsessionbundle_location_longitude').val(helpMap.getCenter().lng());
    });
});
