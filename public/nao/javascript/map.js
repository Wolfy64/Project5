function initMap() {

    // ##### Create map and center on your location #####
    var center = {
        lat: 46.725382,
        lng: 2.440091
    };
    var latlng = new google.maps.LatLng(center);
    var mapOptions = {
        zoom: 5,
        center: latlng
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    var geocoder = new google.maps.Geocoder;

    // ##### Add Marker on map #####   
    var marker = new google.maps.Marker({
        map: map,
        icon:'/img/icon-geoloc.png'
        // position: latlng,
    });
}

function geocodeLatLng(geocoder, lat, lng) {
    var latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };

    geocoder.geocode({ 'location': latlng }, function (results, status) {
        if (status === 'OK') {
            if (results[0]) {

                var address = results[0].formatted_address;
                var country = address.split(',', 3)[2];
                var zipcode = address.split(',', 3)[1];
                var department = parseInt(zipcode.substring(0, 3));

                document.getElementById('observation_department').value = department;
                document.getElementById('observation_country').value = country;
            } else {
                window.alert('Aucun résultat trouvé');
            }
        } else {
            window.alert('Geocoder a échoué en raison de: ' + status);
        }
    });
}

if (typeof mapInfos !== 'undefined') {

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

            map.panTo(marker);
            map.setZoom(8);
        });
    }
}

document.addEventListener("DOMContentLoaded", initMap);
document.addEventListener("DOMContentLoaded", addMarker);
