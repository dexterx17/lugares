!function(d,B,m,f){function v(a,b){var c=Math.max(0,a[0]-b[0],b[0]-a[1]),e=Math.max(0,a[2]-b[1],b[1]-a[3]);return c+e}function w(a,b,c,e){var k=a.length;e=e?"offset":"position";for(c=c||0;k--;){var g=a[k].el?a[k].el:d(a[k]),l=g[e]();l.left+=parseInt(g.css("margin-left"),10);l.top+=parseInt(g.css("margin-top"),10);b[k]=[l.left-c,l.left+g.outerWidth()+c,l.top-c,l.top+g.outerHeight()+c]}}function p(a,b){var c=b.offset();return{left:a.left-c.left,top:a.top-c.top}}function x(a,b,c){b=[b.left,b.top];c=
c&&[c.left,c.top];for(var e,k=a.length,d=[];k--;)e=a[k],d[k]=[k,v(e,b),c&&v(e,c)];return d=d.sort(function(a,b){return b[1]-a[1]||b[2]-a[2]||b[0]-a[0]})}function q(a){this.options=d.extend({},n,a);this.containers=[];this.options.rootGroup||(this.scrollProxy=d.proxy(this.scroll,this),this.dragProxy=d.proxy(this.drag,this),this.dropProxy=d.proxy(this.drop,this),this.placeholder=d(this.options.placeholder),a.isValidTarget||(this.options.isValidTarget=f))}function t(a,b){this.el=a;this.options=d.extend({},
z,b);this.group=q.get(this.options);this.rootGroup=this.options.rootGroup||this.group;this.handle=this.rootGroup.options.handle||this.rootGroup.options.itemSelector;var c=this.rootGroup.options.itemPath;this.target=c?this.el.find(c):this.el;this.target.on(r.start,this.handle,d.proxy(this.dragInit,this));this.options.drop&&this.group.containers.push(this)}var r,z={drag:!0,drop:!0,exclude:"",nested:!0,vertical:!0},n={afterMove:function(a,b,c){},containerPath:"",containerSelector:"ol, ul",distance:0,
delay:0,handle:"",itemPath:"",itemSelector:"li",bodyClass:"dragging",draggedClass:"dragged",isValidTarget:function(a,b){return!0},onCancel:function(a,b,c,e){},onDrag:function(a,b,c,e){a.css(b)},onDragStart:function(a,b,c,e){a.css({height:a.outerHeight(),width:a.outerWidth()});a.addClass(b.group.options.draggedClass);d("body").addClass(b.group.options.bodyClass)},onDrop:function(a,b,c,e){a.removeClass(b.group.options.draggedClass).removeAttr("style");d("body").removeClass(b.group.options.bodyClass)},
onMousedown:function(a,b,c){if(!c.target.nodeName.match(/^(input|select|textarea)$/i))return c.preventDefault(),!0},placeholderClass:"placeholder",placeholder:'<li class="placeholder"></li>',pullPlaceholder:!0,serialize:function(a,b,c){a=d.extend({},a.data());if(c)return[b];b[0]&&(a.children=b);delete a.subContainers;delete a.sortable;return a},tolerance:0},s={},y=0,A={left:0,top:0,bottom:0,right:0};r={start:"touchstart.sortable mousedown.sortable",drop:"touchend.sortable touchcancel.sortable mouseup.sortable",
drag:"touchmove.sortable mousemove.sortable",scroll:"scroll.sortable"};q.get=function(a){s[a.group]||(a.group===f&&(a.group=y++),s[a.group]=new q(a));return s[a.group]};q.prototype={dragInit:function(a,b){this.$document=d(b.el[0].ownerDocument);var c=d(a.target).closest(this.options.itemSelector);c.length&&(this.item=c,this.itemContainer=b,!this.item.is(this.options.exclude)&&this.options.onMousedown(this.item,n.onMousedown,a)&&(this.setPointer(a),this.toggleListeners("on"),this.setupDelayTimer(),
this.dragInitDone=!0))},drag:function(a){if(!this.dragging){if(!this.distanceMet(a)||!this.delayMet)return;this.options.onDragStart(this.item,this.itemContainer,n.onDragStart,a);this.item.before(this.placeholder);this.dragging=!0}this.setPointer(a);this.options.onDrag(this.item,p(this.pointer,this.item.offsetParent()),n.onDrag,a);a=this.getPointer(a);var b=this.sameResultBox,c=this.options.tolerance;(!b||b.top-c>a.top||b.bottom+c<a.top||b.left-c>a.left||b.right+c<a.left)&&!this.searchValidTarget()&&
(this.placeholder.detach(),this.lastAppendedItem=f)},drop:function(a){this.toggleListeners("off");this.dragInitDone=!1;if(this.dragging){if(this.placeholder.closest("html")[0])this.placeholder.before(this.item).detach();else this.options.onCancel(this.item,this.itemContainer,n.onCancel,a);this.options.onDrop(this.item,this.getContainer(this.item),n.onDrop,a);this.clearDimensions();this.clearOffsetParent();this.lastAppendedItem=this.sameResultBox=f;this.dragging=!1}},searchValidTarget:function(a,b){a||
(a=this.relativePointer||this.pointer,b=this.lastRelativePointer||this.lastPointer);for(var c=x(this.getContainerDimensions(),a,b),e=c.length;e--;){var d=c[e][0];if(!c[e][1]||this.options.pullPlaceholder)if(d=this.containers[d],!d.disabled){if(!this.$getOffsetParent()){var g=d.getItemOffsetParent();a=p(a,g);b=p(b,g)}if(d.searchValidTarget(a,b))return!0}}this.sameResultBox&&(this.sameResultBox=f)},movePlaceholder:function(a,b,c,e){var d=this.lastAppendedItem;if(e||!d||d[0]!==b[0])b[c](this.placeholder),
this.lastAppendedItem=b,this.sameResultBox=e,this.options.afterMove(this.placeholder,a,b)},getContainerDimensions:function(){this.containerDimensions||w(this.containers,this.containerDimensions=[],this.options.tolerance,!this.$getOffsetParent());return this.containerDimensions},getContainer:function(a){return a.closest(this.options.containerSelector).data(m)},$getOffsetParent:function(){if(this.offsetParent===f){var a=this.containers.length-1,b=this.containers[a].getItemOffsetParent();if(!this.options.rootGroup)for(;a--;)if(b[0]!=
this.containers[a].getItemOffsetParent()[0]){b=!1;break}this.offsetParent=b}return this.offsetParent},setPointer:function(a){a=this.getPointer(a);if(this.$getOffsetParent()){var b=p(a,this.$getOffsetParent());this.lastRelativePointer=this.relativePointer;this.relativePointer=b}this.lastPointer=this.pointer;this.pointer=a},distanceMet:function(a){a=this.getPointer(a);return Math.max(Math.abs(this.pointer.left-a.left),Math.abs(this.pointer.top-a.top))>=this.options.distance},getPointer:function(a){var b=
a.originalEvent||a.originalEvent.touches&&a.originalEvent.touches[0];return{left:a.pageX||b.pageX,top:a.pageY||b.pageY}},setupDelayTimer:function(){var a=this;this.delayMet=!this.options.delay;this.delayMet||(clearTimeout(this._mouseDelayTimer),this._mouseDelayTimer=setTimeout(function(){a.delayMet=!0},this.options.delay))},scroll:function(a){this.clearDimensions();this.clearOffsetParent()},toggleListeners:function(a){var b=this;d.each(["drag","drop","scroll"],function(c,e){b.$document[a](r[e],b[e+
"Proxy"])})},clearOffsetParent:function(){this.offsetParent=f},clearDimensions:function(){this.traverse(function(a){a._clearDimensions()})},traverse:function(a){a(this);for(var b=this.containers.length;b--;)this.containers[b].traverse(a)},_clearDimensions:function(){this.containerDimensions=f},_destroy:function(){s[this.options.group]=f}};t.prototype={dragInit:function(a){var b=this.rootGroup;!this.disabled&&!b.dragInitDone&&this.options.drag&&this.isValidDrag(a)&&b.dragInit(a,this)},isValidDrag:function(a){return 1==
a.which||"touchstart"==a.type&&1==a.originalEvent.touches.length},searchValidTarget:function(a,b){var c=x(this.getItemDimensions(),a,b),e=c.length,d=this.rootGroup,g=!d.options.isValidTarget||d.options.isValidTarget(d.item,this);if(!e&&g)return d.movePlaceholder(this,this.target,"append"),!0;for(;e--;)if(d=c[e][0],!c[e][1]&&this.hasChildGroup(d)){if(this.getContainerGroup(d).searchValidTarget(a,b))return!0}else if(g)return this.movePlaceholder(d,a),!0},movePlaceholder:function(a,b){var c=d(this.items[a]),
e=this.itemDimensions[a],k="after",g=c.outerWidth(),f=c.outerHeight(),h=c.offset(),h={left:h.left,right:h.left+g,top:h.top,bottom:h.top+f};this.options.vertical?b.top<=(e[2]+e[3])/2?(k="before",h.bottom-=f/2):h.top+=f/2:b.left<=(e[0]+e[1])/2?(k="before",h.right-=g/2):h.left+=g/2;this.hasChildGroup(a)&&(h=A);this.rootGroup.movePlaceholder(this,c,k,h)},getItemDimensions:function(){this.itemDimensions||(this.items=this.$getChildren(this.el,"item").filter(":not(."+this.group.options.placeholderClass+
", ."+this.group.options.draggedClass+")").get(),w(this.items,this.itemDimensions=[],this.options.tolerance));return this.itemDimensions},getItemOffsetParent:function(){var a=this.el;return"relative"===a.css("position")||"absolute"===a.css("position")||"fixed"===a.css("position")?a:a.offsetParent()},hasChildGroup:function(a){return this.options.nested&&this.getContainerGroup(a)},getContainerGroup:function(a){var b=d.data(this.items[a],"subContainers");if(b===f){var c=this.$getChildren(this.items[a],
"container"),b=!1;c[0]&&(b=d.extend({},this.options,{rootGroup:this.rootGroup,group:y++}),b=c[m](b).data(m).group);d.data(this.items[a],"subContainers",b)}return b},$getChildren:function(a,b){var c=this.rootGroup.options,e=c[b+"Path"],c=c[b+"Selector"];a=d(a);e&&(a=a.find(e));return a.children(c)},_serialize:function(a,b){var c=this,e=this.$getChildren(a,b?"item":"container").not(this.options.exclude).map(function(){return c._serialize(d(this),!b)}).get();return this.rootGroup.options.serialize(a,
e,b)},traverse:function(a){d.each(this.items||[],function(b){(b=d.data(this,"subContainers"))&&b.traverse(a)});a(this)},_clearDimensions:function(){this.itemDimensions=f},_destroy:function(){var a=this;this.target.off(r.start,this.handle);this.el.removeData(m);this.options.drop&&(this.group.containers=d.grep(this.group.containers,function(b){return b!=a}));d.each(this.items||[],function(){d.removeData(this,"subContainers")})}};var u={enable:function(){this.traverse(function(a){a.disabled=!1})},disable:function(){this.traverse(function(a){a.disabled=
!0})},serialize:function(){return this._serialize(this.el,!0)},refresh:function(){this.traverse(function(a){a._clearDimensions()})},destroy:function(){this.traverse(function(a){a._destroy()})}};d.extend(t.prototype,u);d.fn[m]=function(a){var b=Array.prototype.slice.call(arguments,1);return this.map(function(){var c=d(this),e=c.data(m);if(e&&u[a])return u[a].apply(e,b)||this;e||a!==f&&"object"!==typeof a||c.data(m,new t(c,a));return this})}}(jQuery,window,"sortable");

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

function renderPlaceInfo(place){
    console.log('renderPLacesInfo');
    var contenedor = $('#detail');
    var template = $('.template-lugar-info');
    var item = template.clone().removeClass('template-lugar-info');
    if(typeof place.photos!== "undefined")
        item.find('img').attr('src',place.photos[0].getUrl({'maxWidth': 200, 'maxHeight': 250}));
    item.find('h3').text(place.name);
    item.find('button.visitado').attr('place',place.place_id);
    item.find('.direction').text(place.formatted_address);
    item.find('.international-phone').text(place.international_phone_number);
    item.find('.phone').text(place.formatted_phone_number);
    item.find('.website').text(place.website);
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
    var res = confirm('Conoces este lugar?');
    if(res){
        mark_place($(this).attr('place'));
    }else{
        alert('viaja mas');
    }
}

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

  $( document ).on( 'click', 'button.visitado', onMarkPlace );

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
