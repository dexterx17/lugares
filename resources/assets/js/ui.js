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
