/*
  Update the welcome screen with information from friendCache.
*/
function renderWelcome() {
    var welcome = $('#welcome');
    welcome.find('.first_name').html(friendCache.me.first_name);
    welcome.find('.profile').attr('src', friendCache.me.picture.data.url);
    welcome.find('.stats .coins').html(Parse.User.current().get('coins'));
    welcome.find('.stats .bombs').html(Parse.User.current().get('bombs'));
}
/*
  Update scores of friends
*/
function renderPlaces(places) {
    console.log('renderPLaces');
    var list = $('#lugares');
    var template = $('.template-lugar');
    for (var i = 0; i < places.length; i++) {
        var item = template.clone().removeClass('template-lugar').addClass('media');
        item.attr('id', places[i].place_id);
        item.find('a').attr('href',places[i].place_id);
        item.find('.media-heading').html(places[i].name);
        item.find('img').attr('src',(typeof places[i].photos !== "undefined")?places[i].photos[0].getUrl({'maxWidth': 50, 'maxHeight': 50}):places[i].icon);
        item.find('img').attr('alt',places[i].name);
        item.find('.vicinity').html(places[i].vicinity);
        list.append(item);
    }
    $('#lugares .loading').fadeOut('fast');
    $('#n_lugares').html(places.length);
}

function setBtnIniciar() {
    var url = $('#btnIniciar').attr('base-url');
    var provincia_id = $('#select_provincia').val();
    var categoria_id = $('#select_categoria').val();
    url += '/' + categoria_id + '/' + provincia_id;
    $('#btnIniciar').attr('href', url);
    $('#provincia_categoria_seleccionada').html(url);
}

function onChangeProvincia(e) {
    e.preventDefault();
    setBtnIniciar();
}

function onChangeCategoria(e) {
    e.preventDefault();
    setBtnIniciar();
}

function onListPlaceClick(e){
    e.preventDefault();
    if($(this).hasClass('local')){
    	get_info($(this).attr('href'));
    }else{
        detail_info($(this).attr('href'));
    }
}

$('#btn_lugares').on('click',function(e){
    $('#tabs a[href="#lugares"]').tab('show');
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
/**
 * Copyright (c) 2014-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to use,
 * copy, modify, and distribute this software in source code or binary form for use
 * in connection with the web services and APIs provided by Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use of
 * this software is subject to the Facebook Developer Principles and Policies
 * [http://developers.facebook.com/policy/]. This copyright notice shall be
 * included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
 * IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/*
  App-specific configuration for your game.

  You will need to configure:
    - the URL to the server where you are hosting the game source code.
    - create a new App and retrieve the app ID and namespace from Facebook
    Developer site at https://developers.facebook.com/apps
*/
var server_url = "http://169.57.152.110/fb";
var appId = '1313714368710654';
var appNamespace = 'friendsconocesecuadormashsample';
var appCenterURL = '//www.facebook.com/appcenter/' + appNamespace;

var g_useFacebook = true;
var bombCost = 5; // coins

var defaults = {
  puntos: 0,
  medallas: 0
}

/*
  Code initialization
*/
$( document ).ready(function() {

  // Register input event listeners
  $( document ).on( 'change', '#select_provincia', onChangeProvincia );

  $( document ).on( 'change', '#select_categoria', onChangeCategoria );

  $( document ).on( 'click', '.media a', onListPlaceClick );

 // $( document ).on( 'mousedown', '#canvas', onGameCanvasMousedown );

  /*
  FB initialization code.
  https://developers.facebook.com/docs/javascript/reference/FB.init/

  The method FB.init() is used to initialize and setup the SDK.

  @status   informs the SDK that it should check the player's
  authentication status as part of the initialization process.

  @frictionlessRequests   lets players send requests to friends from an app
  without having to click on a pop-up confirmation dialog. When sending a
  request to a friend, a player can authorize the app to send subsequent
  requests to the same friend without another dialog. This streamlines the
  process of sharing with friends.
  */
  /*FB.init({
    appId: appId,
    frictionlessRequests: true,
    status: true,
    version: 'v2.5'
  });
*/
  /*
  Reports that the page is now usable by the user, for collecting performance
  metrics.
  https://developers.facebook.com/docs/reference/javascript/FB.Canvas.setDoneLoading
  */
//  FB.Canvas.setDoneLoading();

  /*
  Registers the callback for inline processing of user actions
  https://developers.facebook.com/docs/reference/javascript/FB.Canvas.setUrlHandler
  */
//  FB.Canvas.setUrlHandler( urlHandler );

  /*
  Checking the authentication status is an asynchronous process which will
  start as soon as the SDK has been initialized and will fire the two events
  auth.authResponseChange and auth.statusChange upon completion.

  By subscribing to these events, we can control what happens next in the
  initialization process.
  */
//  FB.Event.subscribe('auth.authResponseChange', onAuthResponseChange);
//  FB.Event.subscribe('auth.statusChange', onStatusChange);
});

//# sourceMappingURL=app.js.map
