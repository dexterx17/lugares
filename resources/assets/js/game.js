$('#btn_lugares').on('click',function(e){
    $('#tabs a[href="#lugares"]').tab('show');
});

function mark_place(place_id){
    console.log('mark_place');
    var url = $('button.visitado').attr('base-url');
    
    swal({
      title: "Lo conoces?",
      text: "Haz visitado este lugar?",
      html:true,
      showCancelButton: true,
      //confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, lo conozco!",
      cancelButtonText: "Aun no :)",
      closeOnConfirm: false
    },
    function(){
        var token=$('#lugares').attr('token');
        $.post(url,{'place_id':place_id,_token: token},function(response){
            if(response.google_id){
                $('#'+response.google_id).fadeOut('slow');
                swal("Visitado!", "Genial, +10 puntos", "success");
                $('#tabs a[href="#explorados"]').tab('show');
                movePlace(response.google_id);
            }else{

            }
        },'json');
    });
}

function get_info(place_id){
    console.log('get_info');
    var url=$('#lugares').attr('base-url');
    $.get(url+place_id,function(response){
        console.log(response);
        $('#tabs a[href="#detail"]').tab('show');
        var el = build_detail_from_server(response);
        $('#detail').html(el);
        $('button.visitado').on('click',function(e){
            e.preventDefault();
            var res = confirm('Conoces este lugar?');
            if(res){
                mark_place($(this).attr('place'));
            }else{
                alert('viaja mas');
            }
        });
    },'json');
}

var map;
var infoWindow;
var cicle;
var showVisited=true;
var markers = [];
var radio = 800;
function initMap() {
    console.log('initMap');
    var latitud = parseFloat($('.lat').html());
    var longitud = parseFloat($('.lng').html());
    var zoom = parseFloat($('.zoom').html());
    var categorias = [$('#id_categoria').html()];
    console.log('lat:'+latitud);
    console.log('lng:'+longitud);
    console.log('zoom:'+zoom);
    console.log('--------------------------------------------------------------------');

    map = new google.maps.Map(document.getElementById('mapa'), {
        center: {lat: latitud , lng:  longitud},
        zoom: parseInt($('.zoom').html())
    });

    circle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#00FF00',
            fillOpacity: 0.0,
            map: map,
            draggable:true,
            center: {lat: latitud , lng:  longitud},
            radius: radio
    });

    map.addListener('zoom_changed', function() {
        $('.zoom').html(map.getZoom());
        if(map.getZoom()<15){
            console.log('radio 10000');
            radio=1000;
            circle.setRadius(radio);
        }else if((map.getZoom()>=15) && (map.getZoom()<17)){
            console.log('radio 500');
            radio=500;
            circle.setRadius(radio);
        }else if((map.getZoom()>=17) && (map.getZoom()<20)){
            console.log('radio 200');
            radio=200;
            circle.setRadius(radio);
        }else{
            console.log('radio 100');
            radio=100;
            circle.setRadius(radio);
        }
        buscar_lugares(categorias, radio);
    });

    circle.addListener('dragend', function(e) {
        console.log('dragned circle');
        console.log(e);
        buscar_lugares(categorias, radio);
    });

    circle.addListener('center_changed', function(e) {
        var bounds =map.getBounds(); 
        var centro =circle.getCenter();
        $('.bounds').html(bounds.b.b+' , '+bounds.b.f+'  ::  '+bounds.f.b+' , '+bounds.f.f);
        $('.lat').html(centro.lat());
        $('.lng').html(centro.lng());
       // circle.setCenter(centro);
    });

    infoWindow = new google.maps.InfoWindow();
  

    // Try HTML5 geolocation.
    /*if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            map.setCenter(pos);

        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }*/

    buscar_lugares(categorias, radio);
}


function animate_circle(){
    var opacity=0;
    var interval = setInterval(function(){
        circle.setOptions({
            'fillOpacity':(opacity+=0.1),
            'strokeColor': '#FF0000',
            'strokeOpacity': 0.8,
            'strokeWeight': 2,
        });
      //  console.log('opacity: '+opacity);
    },250);

    setTimeout(function(){
        console.log('fillopacity: ');
        circle.setOptions({
            'fillOpacity':0,
            'strokeColor': '#00FF00',
            'strokeOpacity': 1,
            'strokeWeight':3
        });
        clearInterval(interval);
    }, 2500);
}
function detail_info(place_id){
    console.log('detail_info');
    updatePeticiones(1);
    var request = {
        placeId: place_id
    };

    service = new google.maps.places.PlacesService(map);
    service.getDetails(request, callback);

    function callback(place, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
        updatePeticionesResponses(1);
        $('#tabs a[href="#detail"]').tab('show');
        renderPlaceInfo(place);
      }else{
        updatePeticionesResponses(1);
        $('#detail').html('no info');
      }
    }
}

function buscar_lugares(categoria,radio){
    console.log('buscar_lugares');
    animate_circle();
    console.log('categoria: ');
    console.log(categoria);
    console.log('radio: '+radio);
    $('#lugares').prepend('<div class="loading"><i class="fa fa-spinner"></i>Loading...</div>');
    updatePeticiones(1);
    var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: circle.getCenter(),
          radius: circle.getRadius(),
          type: categoria
    }, function callback_lugares(places, status) {
        console.log('places');
        console.log(places);
        console.log('status');
        console.log(status);
            var items = [];
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                updatePeticionesResponses(1);
                for (var i = 0; i < places.length; i++) {
                    if(!($('#lugares .media#'+places[i].place_id).length) && !($('#explorados .media#'+places[i].place_id).length)){
                        items.push({
                            place_id:places[i].place_id,
                            lat: places[i].geometry.location.lat(),
                            lng: places[i].geometry.location.lng(),
                        });
                        createMarker(places[i],i*200);
                    }
                }
                var url=$('#lugares').attr('base-url');
                var token=$('#lugares').attr('token');
                $.post(url,{
                    type:categoria,
                    _token: token,
                    items:items
                },function(response){
                    console.log(response);
                    $('#n_lugares_total').html(parseInt($('#n_lugares_total').html())+response.new_items);
                    setTimeout(function(){
                        for (var i = 0; i < response.sync_items.length; i++) {
                            var item = response.sync_items[i];
                            renderUpdatePlace(item);
                        };
                    },2000)
                });
                $('#lugares .loading').fadeOut('slow').remove();
            }else{
                updatePeticionesResponses(1);
                $('#lugares .loading').fadeOut('slow').remove();
            }
    });
}

function createMarker(place,timeout) {
    window.setTimeout(function() {
        renderPlace(place,(markers.length)+1);
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
            map: map,
            position: place.geometry.location,
            place_id: place.place_id,
            icon: normalIcon(),
            visited:false,
            animation: google.maps.Animation.DROP
        });
        markers.push(marker);
        google.maps.event.addListener(marker, 'click', function() {
          infoWindow.setContent(place.name);
          infoWindow.open(map, this);
          detail_info(place.place_id);
        });
    },timeout);
}

 function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(null);
    }
    markers = [];
}


function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}