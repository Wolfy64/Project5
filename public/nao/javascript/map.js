function addMarker() {
    var latlngArr = mapInfos
        .replace('[', '')
        .replace(']', '')
        .replace(/"/g, '')
        .split(',')
    ;

    latlngArr.forEach(function (latlngArr) {
        var latlng = latlngArr.split('/');
        var marker = {
            lat: parseFloat(latlng[0]),
            lng: parseFloat(latlng[1])
        };

        new google.maps.Marker({
            map: map,
            icon: '/img/icon-geoloc.png',
            position: marker,
        });
    });

}


document.addEventListener("DOMContentLoaded", addMarker);