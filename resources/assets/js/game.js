$('#btn_lugares').on('click',function(e){
    $('#tabs a[href="#lugares"]').tab('show');
});

function mark_place(place_id){
    $.post('{{ url("visited") }}',{'place_id':place_id,_token: '{{ Session::token() }}'},function(response){
        console.log(response);
    });
}

function get_info(place_id){
    $.get('{{ url("loader") }}/'+place_id,function(response){
        console.log('response');
        console.log(response);
        $('#tabs a[href="#detail"]').tab('show');
        var categorias =[];
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
var infoWindow
function initMap() {
    console.log('initMap');
    var latitud = parseFloat($('.lat').html());
    var longitud = parseFloat($('.lng').html());
    var zoom = parseFloat($('.zoom').html());
    var radio = 2500;
    var categorias = [$('#id_categoria').html()];
    console.log('lat:'+latitud);
    console.log('lng:'+longitud);
    console.log('zoom:'+zoom);
    console.log('--------------------------------------------------------------------');

    map = new google.maps.Map(document.getElementById('mapa'), {
        center: {lat: latitud , lng:  longitud},
        zoom: parseInt($('.zoom').html())
    });

    map.addListener('zoom_changed', function() {
        $('.zoom').html(map.getZoom());

        buscar_lugares(categorias, radio);
    });

    map.addListener('mousemove', function(e) {
        $('.lat').html(e.latLng.lat);
        $('.lng').html(e.latLng.lng);
    });

    map.addListener('bounds_changed', function(e) {
        var bounds =map.getBounds(); 
        $('.bounds').html(bounds.b.b+' , '+bounds.b.f+'  ::  '+bounds.f.b+' , '+bounds.f.f);
    });

    infoWindow = new google.maps.InfoWindow({map: map});
  

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

function detail_info(place_id){
    //'ChIJN1t_tDeuEmsRUsoyG83frY4'
    var request = {
        placeId: place_id
    };

    service = new google.maps.places.PlacesService(map);
    service.getDetails(request, callback);

    function callback(place, status) {
      if (status == google.maps.places.PlacesServiceStatus.OK) {
        $('#tabs a[href="#detail"]').tab('show');
        var categorias =[];
        for (var i = 0; i < place.types.length; i++) {
            categorias.push(place.types[i]);
        };
        renderPlaceInfo(place);
        var img='';
        if(typeof place.photos!== "undefined"){
            img = place.photos[0].getUrl({'maxWidth': 200, 'maxHeight': 250});
            console.log('img: '+img);
        }
        $.post('{{ url("loader") }}/'+place.place_id,{
            name : place.name,
            place_id : place.place_id,
            vecinity : place.vicinity,
            imagen:img,
            direccion : place.formatted_address,
            telefono : place.formatted_phone_number,
            categorias: categorias,
            web : place.website,
            _token: '{{ Session::token() }}'
        },function(response){
            console.log(response);
        });
      }
    }
}

function buscar_lugares(categorias,radio){
    var lat = parseFloat($('.lat').html());
    var lng = parseFloat($('.lng').html());
    console.log('lat: '+lat);
    console.log('lng: '+lng);
    console.log('categorias: ');
    console.log(categorias);
    console.log('radio: '+radio);
    var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: {lat: lat , lng: lng},
          radius: radio,
          type: categorias
    }, function callback_lugares(results, status) {
        console.log('results');
        console.log(results);
        console.log('status');
        console.log(status);
            var items = [];
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                renderPlaces(results);
              for (var i = 0; i < results.length; i++) {
                items.push({
                    'place_id':results[i].place_id,
                    'name':results[i].name,
                });
              
                createMarker(results[i]);

                var url=$('#lugares').attr('base-url');
                var token=$('#lugares').attr('token');
                $.post(url,{
                    name : results[i].name,
                    place_id : results[i].place_id,
                    vecinity : results[i].vicinity,
                    icon : results[i].icon,
                    _token: token,
                    lat: results[i].geometry.location.lat(),
                    lng: results[i].geometry.location.lng(),
                    type:categorias
                },function(response){
                    console.log(response);
                });

              }
            }
    });
}

function createMarker(place) {
    var placeLoc = place.geometry.location;
    var marker = new google.maps.Marker({
      map: map,
      position: place.geometry.location,
      place_id: place.place_id,
      icon: place.icon
    });
    google.maps.event.addListener(marker, 'click', function() {
      infoWindow.setContent(place.name);
      infoWindow.open(map, this);
      detail_info(place.place_id);
    });
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}