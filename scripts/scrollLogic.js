$(document).ready(function(){
  var height = window.innerHeight;
  var scroll;
  var lastPostI = 4;
  var checkScroll = true;
  $(window).scroll(function () {
    scroll = $(this).scrollTop();
    if((scroll + (2*height) > document.documentElement.scrollHeight) && checkScroll){
      checkScroll = false;
      $("#latest-workouts").load('scripts/server/getNextPosts.php', {lastPostIndex: lastPostI}, function(){
        lastPostI+=4;
        $('.post').find('h6').each(function(){
          $(this).parent().next().hide();
          $(this).next().hide();
          setTimeout(function(){checkScroll = true;}, 1500);
          return;
        });
      });
    }
  })
});
