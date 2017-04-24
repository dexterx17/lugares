<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>place API Google Mapss</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/> 

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    
    <style>
        #mapa{
            width: 100%;
            height: 500px;
        }

        #controles{
        }

        #lugares .media:hover{
            border: 2px dashed black;
        }
        #detail img{
            width: 100%;
            height:180px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                Pruebas de libreria places API Google maps
                <div id="controles" class="pull-right btn-group">
                    <select name="tipo" id="tipo">
                        <option value="amusement_park">amusement_park</option>
                        <option value="aquarium">aquarium</option>
                        <option value="art_gallery">art_gallery</option>
                        <option value="bar">bar</option>
                        <option value="cafe">cafe</option>
                        <option value="campground">campground</option>
                        <option value="casino">casino</option>
                        <option value="cemetery">cemetery</option>
                        <option value="church">church</option>
                        <option value="city_hall">city_hall</option>
                        <option value="clothing_store">clothing_store</option>
                        <option value="convenience_store">convenience_store</option>
                        <option value="courthouse">courthouse</option>
                        <option value="embassy">embassy</option>
                        <option value="florist">florist</option>
                        <option value="gym">gym</option>
                        <option value="hindu_temple">hindu_temple</option>
                        <option value="home_goods_store">home_goods_store</option>
                        <option value="liquor_store">liquor_store</option>
                        <option value="locksmith">locksmith</option>
                        <option value="lodging">lodging</option>
                        <option value="meal_delivery">meal_delivery</option>
                        <option value="meal_takeaway">meal_takeaway</option>
                        <option value="mosque">mosque</option>
                        <option value="movie_theater">movie_theater</option>
                        <option value="museum">museum</option>
                        <option value="night_club">night_club</option>
                        <option value="parking">parking</option>
                        <option value="pet_store">pet_store</option>
                        <option value="restaurant">restaurant</option>
                        <option value="shoe_store">shoe_store</option>
                        <option value="shopping_mall">shopping_mall</option>
                        <option value="spa">spa</option>
                        <option value="stadium">stadium</option>
                        <option value="subway_station">subway_station</option>
                        <option value="synagogue">synagogue</option>
                        <option value="train_station">train_station</option>
                        <option value="zoo">zoo</option>
                    </select>
                    <select name="radio" id="radio">
                        <option value="1000">1000</option>
                        <option selected value="5000">5000</option>
                        <option value="10000">10000</option>
                        <option value="50000">50000</option>
                    </select>
                    <button type="button" id="buscar">BUSCAR</button>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div id="mapa"></div>   
                    </div>
                    <div class="col-lg-4">
                        <div id="tabs">
                          <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#lugares" aria-controls="lugares" role="tab" data-toggle="tab">Lugares</a></li>
                            <li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detalles</a></li>
                           </ul>

                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="lugares">
                            @foreach($items as $key=>$item)
                                <div class="media">
                                    <div class="media-left">
                                        <a href="{{ $item->google_id }}">
                                            <img alt="{{ $item->name }}" class="media-object" src="{{ $item->categorias()->first()->icono_url }}"/>
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            {{ $item->name }}
                                        </h4>
                                        {{ $item->vecinity }}
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div role="tabpanel" class="tab-pane" id="detail">
                                Selecciona un <button  id="btn_lugares" title="Lugar">lugar</button>
                            </div>

                          </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="pull-left">
                    <span class="zoom"></span>
                    |||
                    <span class="lat"></span>,
                    <span class="lng"></span>
                    |||
                    <span class="bounds"></span>
                </div>
                <hr>
                <a href="https://developers.google.com/maps/documentation/javascript/marker-clustering" target="_blank">https://developers.google.com/maps/documentation/javascript/marker-clustering</a>
                <br>
                <a href="https://developers.google.com/maps/documentation/javascript/events" target="_blank">https://developers.google.com/maps/documentation/javascript/events</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $('#btn_lugares').on('click',function(e){
            $('#tabs a[href="#lugares"]').tab('show');
        });

        $('#buscar').on('click',function(e){
            buscar_lugares($('.lat').html(),$('.lng').html());
        });

        $('.media a').on('click',function(e){
            e.preventDefault();
            detail_info($(this).attr('href'));
        });

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

        function detail_info(place_id){
            //'ChIJN1t_tDeuEmsRUsoyG83frY4'
            var request = {
                placeId: place_id
            };

            service = new google.maps.places.PlacesService(map);
            service.getDetails(request, callback);

            function callback(place, status) {
                console.log('place:');
                console.log(place);
                console.log('status:');
                console.log(status);
              if (status == google.maps.places.PlacesServiceStatus.OK) {
                $('#tabs a[href="#detail"]').tab('show');
                var categorias =[];
                var el = '<div class="panel"><div class="panel-heading"><h3>'+place.name+'</h4></div><div class="panel-body">';
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
                 if(typeof place.photos!== "undefined")
                    img = place.photos[0].getUrl({'maxWidth': 200, 'maxHeight': 250});
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
                /*var item = $('div');
                item.addClass('media');
                item.on('click',function(e){
                    alert('click');
                });*/
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
                    detail_info($(this).attr('href'));
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

    </script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&libraries=places&callback=initMap">
    </script>
</body>
</html>