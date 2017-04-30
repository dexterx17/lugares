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
    item.find('.vicinity').html(place.place_id);
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

function normalIcon() {
  return {
    url: '../../img/marker-red.png'
  };
}
function visitedIcon() {
  return {
    url: '../../img/marker-green.png'
  };
}
function highlightedIcon() {
  return {
    url: '../../img/marker-orange.png'
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
    var index = $(this).index();
    markers[index-1].setIcon(highlightedIcon());
}

function onHoverOutPlace(){
    var index = $(this).index();
    markers[index-1].setIcon(normalIcon());
}