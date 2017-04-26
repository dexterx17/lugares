@extends('layouts.app')
@section('content')
<div class="container">
    <div id="fb-root"></div>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $provincia->provincia }}
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
                        <li role="presentation" class="active"><a href="#lugares" aria-controls="lugares" role="tab" data-toggle="tab">Lugares <span id="n_lugares" class="badge">{{ count($items) }}</span></a></li>
                        <li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detalles</a></li>
                       </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="lugares">
                        @foreach($items as $key=>$item)
                            <div class="media @if($item->visited(1)->count()) bg-success @endif" id="{{ $item->google_id }}">
                                <div class="media-left">
                                    <a href="{{ $item->google_id }}" class="@if($item->loaded) local @endif">
                                        <img alt="{{ $item->name }}" class="media-object" width="50" height="50" src="@if($item->imagen!="") {{ $item->imagen }} @else {{ $item->categorias()->first()->icono_url }} @endif"/>
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
                            <!--<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3>
                                        Titi Park
                                        <button type="button" place="" class="visitado pull-right btn btn-info">Visitado</button>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                <img class="img-responsive" src="https://lh4.googleusercontent.com/-6YHtST5k04w/WPI35S-cPqI/AAAAAAAAABE/Nk0oJtFflF8P6DlM_jAsswpIs6qfjM-zQCLIB/w200-h250-k/">
                                    <ul class="list-group">
                                        <li class="list-group-item"><i class="glyphicon glyphicon-home"></i> Huayna Capac, Ambato 180202, Ecuador</li>
                                        <li class="list-group-item"><i class="glyphicon glyphicon-earphone"></i> null</li>
                                        <li class="list-group-item"><i class="glyphicon glyphicon-globe"></i> <a href="undefined">website</a></li>
                                        <li class="list-group-item">Categorias: 
                                            <ul>
                                                <li><a href="#">amusement_park</a></li>
                                                <li><a href="#">establishment</a></li>
                                                <li><a href="#">point_of_interest</a></li>
                                            </ul>
                                        </li>
                                    </ul
                                    ><hr>
                                </div>
                            </div>-->
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
@endsection
@section('js')
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&libraries=places&callback=initMap">
    </script>
@endsection