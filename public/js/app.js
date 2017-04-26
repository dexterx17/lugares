/*
  Update the welcome screen with information from friendCache.
*/
function renderWelcome() {
  var welcome = $('#welcome');
  welcome.find('.first_name').html(friendCache.me.first_name);
  welcome.find('.profile').attr('src',friendCache.me.picture.data.url);
  welcome.find('.stats .coins').html(Parse.User.current().get('coins'));
  welcome.find('.stats .bombs').html(Parse.User.current().get('bombs'));
}



$('#btn_lugares').on('click',function(e){
    $('#tabs a[href="#lugares"]').tab('show');
});

$('#buscar').on('click',function(e){
    buscar_lugares($('.lat').html(),$('.lng').html());
});

$('.media a').on('click',function(e){
    e.preventDefault();
    if($(this).hasClass('local')){
        get_info($(this).attr('href'));
    }else{
        detail_info($(this).attr('href'));
    }
});
$('button.visitado').on('click',function(e){
    e.preventDefault();
    var res = confirm('Conoces este lugar?');
    if(res){
        mark_place($(this).attr('place'));
    }else{
        alert('viaja mas');
    }
});

function mark_place(place_id){
    $.post('{{ url("visited") }}',{'place_id':place_id,'user_id':1,_token: '{{ Session::token() }}'},function(response){
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
  map = new google.maps.Map(document.getElementById('mapa'), {
    center: {lat: -1.2430580707463799 , lng:  -78.6267551779747},
    zoom: 15
  });

    map.addListener('zoom_changed', function() {
        $('.zoom').html(map.getZoom());
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
  if (navigator.geolocation) {
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
  }

}


function build_detail_from_server(place){
    var el = '<div class="panel';
    el += '"><div class="panel-heading"><h3>'+place.name;
    el += '<button type="button" place="'+place.google_id+'" class="visitado pull-right btn btn-info">Visitado</button>';
    el +='</h3></div><div class="panel-body">';
    if(typeof place.imagen!== "undefined")
        el += '<img class="img-responsive" src="'+place.imagen+'">';
    el += '<ul class="list-group">';
    el += '<li class="list-group-item"><i class="glyphicon glyphicon-home"></i> '+place.direccion+'</li>';
    if (typeof place.telefono !== 'undefined' )
        el += '<li class="list-group-item"><i class="glyphicon glyphicon-earphone"></i> '+place.telefono+'</li>';
    el += '<li class="list-group-item"><i class="glyphicon glyphicon-globe"></i> <a href="'+place.website+'">website</a></li>';
    el += '<li class="list-group-item">Categorias: ';
        el += '<ul >';
        for (var i = 0; i < place.cats.length; i++) {
            el += '<li><a href="#" >'+place.cats[i]+'</a></li>';
        };
        el += '</ul>';
    el += '</li>';
    el += '</ul><hr>';
    el += '</div></div>';
    return el;
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
        var el = '<div class="panel"><div class="panel-heading"><h3>';
        el += '<button type="button" place="'+place.place_id+'" class="visitado pull-right btn btn-info">Visitado</button>';
        el += place.name+'</h3></div><div class="panel-body">';
        if(typeof place.photos!== "undefined")
            el += '<img class="img-responsive" src="'+place.photos[0].getUrl({'maxWidth': 200, 'maxHeight': 250})+'">';
        el += '<ul class="list-group">';
        el += '<li class="list-group-item"><i class="glyphicon glyphicon-home"></i> '+place['formatted_address']+'</li>';
        if (typeof place.international_phone_number !== 'undefined' )
            el += '<li class="list-group-item"><i class="glyphicon glyphicon-earphone"></i> '+place['international_phone_number']+'</li>';
        if (typeof place.formatted_phone_number !== 'undefined' )
            el += '<li class="list-group-item"><i class="glyphicon glyphicon-earphone"></i> '+place['formatted_phone_number']+'</li>';
        el += '<li class="list-group-item"><i class="glyphicon glyphicon-globe"></i> <a href="'+place['website']+'">website</a></li>';
        el += '<li class="list-group-item">Categorias: ';
            el += '<ul >';
            for (var i = 0; i < place.types.length; i++) {
                el += '<li><a href="#" >'+place.types[i]+'</a></li>';
                categorias.push(place.types[i]);
            };
            el += '</ul>';
        el += '</li>';
        el += '</ul><hr>';
        el += '</div></div>';
        $('#detail').html(el);
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
            $('button.visitado').on('click',function(e){
                e.preventDefault();
                var res = confirm('Conoces este lugar?');
                if(res){
                    mark_place($(this).attr('place'));
                }else{
                    alert('viaja mas');
                }
            });
      }
    }
}

function buscar_lugares(lat,lng){
    console.log('lat: '+lat);
    console.log('lng: '+lng);
    var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: {lat: parseFloat(lat) , lng: parseFloat(lng)},
          radius: $('#radio').val(),
          type: [$('#tipo').val()]
    }, callback);
}

function callback(results, status) {
    var items = [];
    if (status === google.maps.places.PlacesServiceStatus.OK) {
      for (var i = 0; i < results.length; i++) {
        items.push({
            'place_id':results[i].place_id,
            'name':results[i].name,
        });
        console.log('-------------------------------------------------------');
        var item = '<div class="media"><div class="media-left"><a href="'+results[i]['place_id'];
         if(typeof results[i].photos !== "undefined"){
            item += '"><img class="media-object" src="'+results[i].photos[0].getUrl({'maxWidth': 50, 'maxHeight': 50});
         }else{
            item += '"><img class="media-object" src="'+results[i].icon ;
         }
        item += '" alt="'+results[i].name+'"></a></div><div class="media-body">';
        item += '<h4 class="media-heading">'+results[i].name+'</h4>';
        item += results[i].vicinity + '</div></div>';
        $('#lugares').append(item);
        createMarker(results[i]);

        $.post('{{ url("loader") }}',{
            name : results[i].name,
            place_id : results[i].place_id,
            vecinity : results[i].vicinity,
            icon : results[i].icon,
            _token: '{{ Session::token() }}',
            lat: results[i].geometry.location.lat(),
            lng: results[i].geometry.location.lng(),
            type:$('#tipo').val()
        },function(response){
            console.log(response);
        });

      }
        $('.media a').on('click',function(e){
            e.preventDefault();
            if($(this).hasClass('local')){

            }else{
                detail_info($(this).attr('href'));
            }
        });
    }
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
//# sourceMappingURL=app.js.map
