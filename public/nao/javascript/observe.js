function initMap() {

    // ##### Create map and center on your location #####
    var center = {
        lat: 46.725382,
        lng: 2.440091
    };
    var latlng = new google.maps.LatLng(center);
    // var latlng = new google.maps.LatLng(paris);
    var mapOptions = {
        zoom: 5,
        center: latlng
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var geocoder = new google.maps.Geocoder;

    // ##### Add Marker on map #####   
    var icon = {
        url: '/img/icon-geoloc.png',
        scaledSize: new google.maps.Size(50, 60),
    };

    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        icon: icon
    });

    // ##### Add info Window on map #####
    var infoWindow = new google.maps.InfoWindow();
    var infoWindowContent = document.getElementById('infoWindow-content');
    infoWindow.setContent(infoWindowContent);

    // ##### Auto-complete input field (Ville) #####
    var input = document.getElementById('observation_place');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("Aucun détail disponible pour la saisie: '" + place.name + "'");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(16);
        }

        // ##### Set Marker on map #####
        marker.setPosition(place.geometry.location);
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();

        // ##### Set info Window on map #####
        infoWindow.setContent(
            '<strong>' + place.name + '</strong><br>' +
            "Coordonnées GPS: " + marker.getPosition().toUrlValue(6)
        );
        infoWindow.open(map, marker);

        // ##### Set GPS value in observation field #####
        document.getElementById('observation_latitude').value = lat;
        document.getElementById('observation_longitude').value = lng;
        geocodeLatLng(geocoder, lat, lng);

    });
    autocomplete.bindTo('bounds', map);

    document.getElementById('findMe').addEventListener('click', function () {
        // ##### Try HTML5 geolocation #####
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var position = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                latlng = new google.maps.LatLng(position);
                mapOptions = {
                    zoom: 16,
                    center: latlng
                };
                map = new google.maps.Map(document.getElementById('map'), mapOptions);

                var icon = {
                    url: '/img/icon-geoloc.png',
                    scaledSize: new google.maps.Size(50, 60),
                };

                var marker = new google.maps.Marker({
                    map: map,
                    icon: icon
                });

                // ##### Set Marker on map #####
                marker.setPosition(position);

                // ##### Set info Window on map #####
                infoWindow.setContent("Coordonnées GPS: " + marker.getPosition().toUrlValue(6));
                infoWindow.open(map, marker);

                // ##### Set GPS value in observation field #####
                document.getElementById('observation_latitude').value = marker.getPosition().lat();
                document.getElementById('observation_longitude').value = marker.getPosition().lng();
            }, function () {
                handleLocationError(true, infoWindow, map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(position);
            infoWindow.setContent(browserHasGeolocation ?
                'Erreur: Le service de géolocalisation a échoué.' :
                'Erreur: Votre navigateur ne supporte pas la géolocalisation.');
            infoWindow.open(map);
        }
    });

    google.maps.event.addListener(map, 'click', function (event) {
        // ##### Set Marker on map #####
        marker.setPosition(event.latLng);

        lat = marker.getPosition().lat();
        lng = marker.getPosition().lng();

        // ##### Set info Window on map #####
        infoWindow.setContent("Coordonnées GPS: " + marker.getPosition().toUrlValue(6));
        infoWindow.open(map, marker);

        // ##### Set GPS value in observation field #####
        document.getElementById('observation_latitude').value = lat;
        document.getElementById('observation_longitude').value = lng;
        geocodeLatLng(geocoder, lat, lng);
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

document.addEventListener("DOMContentLoaded", initMap);
