  var departPlace = undefined;
  var destinationPlace = undefined;

  var directionsService = new google.maps.DirectionsService();
  var directionsRenderer = new google.maps.DirectionsRenderer();

    /* Installation de la map Google */
    var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 43.610769, lng: 3.876716},
    zoom: 13
    });
    directionsRenderer.setMap(map);

    var marker = new google.maps.Marker({
      map: map,
      anchorPoint: new google.maps.Point(0, -29)
    });
  
  /* Autocomplete de l'adresse sur les champs départ et destination */
  function initAutoComplete(){
    var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(43.610769, 3.876716));
    
    var departAdress = document.getElementById('devis_course_departAdress');
    var destinationAdress = document.getElementById('devis_course_destinationAdress');

    var options = {
      bounds: defaultBounds
    };
    
    var autocomplete = new google.maps.places.Autocomplete(departAdress, options);
    var autocomplete2 = new google.maps.places.Autocomplete(destinationAdress, options);
    

    function addListeners(){
      /* Listener sur l'adresse de depart */
      autocomplete.addListener('place_changed', function() {
        departPlace = autocomplete.getPlace();
        map.fitBounds(departPlace.geometry.viewport); //zoom sur la map sur l'adresse saisie

        marker.setPosition(departPlace.geometry.location);
        marker.setVisible(true);
      });

      /* Listener sur l'adresse de destination */
      autocomplete2.addListener('place_changed', function() {
        destinationPlace = autocomplete2.getPlace();

        getDistance(departPlace.formatted_address, destinationPlace.formatted_address);
      });
    }
    
    addListeners();
  }
  
  initAutoComplete();

  

  /* Calcul distance */
  function getDistance(origin, destination)
  {
    directionsService.route(
      {
        origin: {query: origin},
        destination: {query: destination},
        travelMode: 'DRIVING'
      },
      function(response, status) {
        if (status === 'OK') {
          directionsRenderer.setDirections(response);
          marker.setVisible(false); // Désactivation du marker d'affichage de l'adresse de départ
          displayDistance(response.routes[0].legs[0].distance.value, response.routes[0].legs[0].duration.text);
        } else {
          window.alert('Directions request failed due to ' + status);
        }
      });
  }

  /* Affichage de la distance résultante*/
  function displayDistance(distanceInM, time){
    distanceInKm = distanceInM / 1000;
    var price = distanceInKm * 1.5;
    
    document.getElementById("estimationResult").classList.remove("d-none");

    SetResultValues(price, distanceInKm, time);
  }

  /* Envoi des valeurs : prix, distance et temps à la vue
  + Insértion dans les hidden fields pour l'envoi de ces 3 données au PHP */
  function SetResultValues(price, distance, time){
    var elem1 = document.getElementById("price").innerHTML = price.toFixed(2) + "€";
    document.getElementById("distance").innerHTML = distance.toFixed(2) + "Km";
    document.getElementById("time").innerHTML = time;

    document.getElementById("devis_course_cost").value = price;
    document.getElementById("devis_course_distance").value = distance;
    document.getElementById("devis_course_duration").value = time;
  }

  function getDistanceInKmByRoutes(routes){
    var distance = 0;

    for (var i = 0; i < routes.length; i++) {
      distance += routes[i].legs.distance;
    }
    console.log("distance : " + distance);
    return distance;
  }
  

  /* Récupération distance */
  function callback(response, status) {
      console.log(response,status);
  }