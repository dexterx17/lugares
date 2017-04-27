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
    var n_lugares = parseInt($('#n_lugares').html());
    $('#n_lugares').html(n_lugares+places.length);
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