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

function addPoints(added_points){
    var puntos = parseInt($('#user_points').html());
    $('#user_points').html(puntos+added_points);
}

function updateItemsBar(incremento){
    var n_vistados = parseInt($('#n_total_visitados').html())+incremento;
    var total = parseInt($('#n_lugares_total').html());
    if(total!=0)
        total = (n_vistados/total)*100;
    $('.bar-lugares').animate({
        width: total+'%'
    },1000,function(){
        $('#n_total_visitados').html(n_vistados);
    });

}

function updatePeticiones(inc){
    $('#n_peticiones').html(parseInt($('#n_peticiones').html())+inc);
}
function updatePeticionesResponses(inc){
    $('#n_peticiones_responses').html(parseInt($('#n_peticiones').html())+inc);
}
/*
  Update scores of friends
*/
function renderPlace(place,marker_index) {
    console.log('renderPLace');
    console.log(place);
    var n_lugares = parseInt($('#n_lugares').html())+1;
    var list = $('#lugares');
    var template = $('.template-lugar');
    var item = template.clone().removeClass('template-lugar').addClass('media');
    item.attr('id', place.place_id);
    item.attr('marker-index', marker_index );
    item.find('.media-left a').attr('href',place.place_id);
    item.find('.media-body a').attr('href',place.place_id);
    item.find('.media-heading a').html(place.name);
    item.find('img').attr('src',(typeof place.photos !== "undefined")?place.photos[0].getUrl({'maxWidth': 50, 'maxHeight': 50}):place.icon);
    item.find('img').attr('alt',place.name);
    item.find('.vicinity').html(place.vicinity);
    list.append(item);
    $('#n_lugares').html(n_lugares);
}

function renderUpdatePlace(place){
    console.log('renderUpdatePLace');
    console.log(place);
    var item = $('#'+place.google_id);
    if(place.visited){
        movePlace(place.google_id);
    }
}

function movePlace(place_id){
    var original = $('#lugares').find('#'+place_id);
    var item = original.clone();
    original.fadeOut('slow').remove();
    if(!$('#explorados .media#'+place_id).length){
        item.addClass('bg-success');
        $(item).hide().appendTo("#explorados").fadeIn('slow');
        $('#n_lugares_explorados').html(parseInt($('#n_lugares_explorados').html())+1);
        $('#n_lugares').html(parseInt($('#n_lugares').html())-1);
        var index = item.attr('marker-index');
        markers[index-1].setIcon(visitedIcon());
        markers[index-1].visited=true;
    }
}

function renderPlaceInfo(place){
    console.log('renderPLacesInfo');
    console.log(place);
    var contenedor = $('#detail');
    var template = $('.template-lugar-info');
    var item = template.clone().removeClass('template-lugar-info');
    if(typeof place.photos!== "undefined")
        item.find('img').attr('src',place.photos[0].getUrl({'maxWidth': 200, 'maxHeight': 250}));
    item.find('h3').contents()[0].nodeValue = place.name;
    item.find('button.visitado').attr('place',place.place_id);
    if(typeof place.formatted_address!== "undefined")
        item.find('.direction').contents()[1].nodeValue = place.formatted_address;
    if(typeof place.international_phone_number!== "undefined")
        item.find('.international-phone').contents()[1].nodeValue = place.international_phone_number;
    if(typeof place.formatted_phone_number!== "undefined")
        item.find('.phone').contents()[1].nodeValue = place.formatted_phone_number;
    if(typeof place.website!== "undefined"){
        item.find('.website a').html(place.website);
        item.find('.website a').attr('href',place.website);
    }
    for (var i = 0; i < place.types.length; i++) {
        item.find('.categorias').append('<li><a href="#" >'+place.types[i]+'</a></li>');
    };
    contenedor.html(item);
}

function setBtnIniciar() {
    var url = $('#btnIniciar').attr('base-url');
    var pais_id = $('#pais_id').val();
    var provincia_id = $('#select_provincia').val();
    var categoria_id = $('#select_categoria').val();
    url += '/' + categoria_id + '/'+ pais_id +'/' + provincia_id;
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
var base_url = $('body').attr('base-url');

function normalIcon() {
  return {
    url: base_url+'/img/marker-red.png'
  };
}
function visitedIcon() {
  return {
    url: base_url+'/img/marker-green.png'
  };
}
function highlightedIcon() {
  return {
    url: base_url+'/img/marker-orange.png'
  };
}

function onListPlaceClick(e){
    e.preventDefault();
    if($(this).hasClass('local')){
    	get_info($(this).attr('href'));
    }else{
        detail_info($(this).attr('href'));
    }
}

function onMarkPlace(e){
    e.preventDefault();
    mark_place($(this).attr('place'));
}

function onHoverInPlace(){
    var index = $(this).attr('marker-index');
    markers[index-1].setIcon(highlightedIcon());
}

function onHoverOutPlace(){
    var index = $(this).attr('marker-index');
    if(markers[index-1].visited){
        markers[index-1].setIcon(visitedIcon());
    }else{
        markers[index-1].setIcon(normalIcon());
    }
}
function onToggleMarkers(){
    showVisited=!showVisited;
    for (var i = 0; i < markers.length; i++) {
        var m = markers[i];
        if (m.visited) {
            m.setVisible(showVisited);
        }
    };
}