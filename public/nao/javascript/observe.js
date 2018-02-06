function initMap() {

    // ##### Create map and center on your location #####
    var paris = {
        lat: 48.8566,
        lng: 2.3522
    };
    var latlng = new google.maps.LatLng(paris);
    var mapOptions = {
        zoom: 5,
        center: latlng
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    // ##### Add Marker on map #####   
    var marker = new google.maps.Marker({
        map: map,
        //position: latlng,
        // icon:'link' To put our own marker
    });

    // ##### Add info Window on map #####
    var infoWindow = new google.maps.InfoWindow();
    var infoWindowContent = document.getElementById('infoWindow-content');
    infoWindow.setContent(infoWindowContent);

    // ##### Auto-complete input field (Ville) #####
    var input = document.getElementById('observation_town');
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

        // ##### Set info Window on map #####
        infoWindow.setContent(
            '<strong>' + place.name + '</strong><br>' +
            "Coordonnées GPS: " + marker.getPosition().toUrlValue(6)
        );
        infoWindow.open(map, marker);

        // ##### Set GPS value in observation field #####
        document.getElementById('observation_latitude').value = marker.getPosition().lat();
        document.getElementById('observation_longitude').value = marker.getPosition().lng();

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

                var marker = new google.maps.Marker({
                    map: map,
                    //position: latlng,
                    // icon:'link' To put our own marker
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

        // ##### Set info Window on map #####
        infoWindow.setContent("Coordonnées GPS: " + marker.getPosition().toUrlValue(6));
        infoWindow.open(map, marker);

        // ##### Set GPS value in observation field #####
        document.getElementById('observation_latitude').value = marker.getPosition().lat();
        document.getElementById('observation_longitude').value = marker.getPosition().lng();
    });
}
