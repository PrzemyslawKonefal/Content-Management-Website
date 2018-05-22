
$(document).ready(function(){

  const trainingsCount = [];
  const timeCount = [];
  const userWorkoutAmount = $('#workoutAmount .single-data');
  const userTimeSpent = $('#timeSpent .single-data');
  for(let i = 0; i<userWorkoutAmount.length; i++){
    trainingsCount.push(userWorkoutAmount.eq(i).attr("value"));
    timeCount.push(userTimeSpent.eq(i).attr("value"));
  }
  let maxAmount = Math.max(...trainingsCount);
  let maxTime = Math.max(...timeCount);
  setTimeout(function(){
    for(let i = 0; i<userWorkoutAmount.length; i++){
      if(trainingsCount[i] <=0 ) {
        userWorkoutAmount.eq(i).css("display", "none");
        userTimeSpent.eq(i).css("display", "none");
      }
      else{
      userWorkoutAmount.eq(i).css("height", `calc(${trainingsCount[i]} / ${maxAmount} * 100%)`);
      userWorkoutAmount.eq(i).find("span").html(trainingsCount[i]);
      userTimeSpent.eq(i).css("height", `calc(${timeCount[i]} / ${maxTime} * 100%)`);
        userTimeSpent.eq(i).find("span").html(timeCount[i]);
      }
    }
  }, 300);

  const trigger = $("#loginTrigger");
  const form = $("#logForm form");
  trigger.click(function(){
    if(form.css("bottom") === "0px") {
      form.animate({"bottom": "-200px", "opacity": "0"}, 1000);
    }
    else{
      $("#logForm").css('z-index', '10');
      form.animate({"bottom": "0px", "opacity": "1"}, 1000);
    }
  })
  const addPost = $("#add-post");
  addPost.click(function(){
    $("body").append("<form id='posting-box' action='scripts/server/addWorkout.php' method='post'><span id = 'close'>X</span><p>Czas treningu</p><input type='number' name='time' min='10' required><p>Rodzaj treningu</p><input type='text' name='type' required><p>Opis</p><textarea name='description'></textarea><input type='submit' value='Dodaj'></form>");
  })
  $("body").on('click', '#close', function(){
    $('#close').parent().remove();
  })

  const placeImageToPost = function(index){
    const post = $('.post').eq(index);
    let name = post.find('h3').html();
    name = name.toLowerCase();
    const path = `./img/characters/${name}/main.jpg`;
    post.find('img').attr('src', path);
  }
  for(let i = 0; i<4; i++)  placeImageToPost(i);

const countAnimation = function(JquerySelector, time){
   let value = JquerySelector.html();
   let valueCounter = 0;
   let frameChangeTime = time/value;
   let interval = setInterval(function(){
       JquerySelector.text(valueCounter);
       if(valueCounter >= value) clearInterval(interval);
       valueCounter++;
   }, frameChangeTime);
}
for(let i = 0; i<2; i++) countAnimation($('h1').eq(i), 2000);

//textareas automatic height
$('textarea').each(function () {
      this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
      this.style.height = 'auto';
      this.style.height = (this.scrollHeight) + 'px';
    });

    //Add name for not logged users in comments section
    $('.comment-left-box').each(function() {
      let input = $(this).find('input').eq(0);
      if(input.attr('value') === ''){
        input.attr('value', 'Anonim');
      }
    });

    //toggle comments and profiles visibility
    $('.post').find('h6').click(function(){
      if($(this).attr('opened') === "true") {
        $(this).parent().next().slideUp();
        $(this).next().slideUp();
        $(this).attr('opened', 'false');
      }
      else{
        $(this).parent().next().slideDown();
        $(this).next().slideDown();
        $(this).attr('opened', 'true');
      }
    })
    $('#show-profiles').click(function(){
        if($(this).attr('opened') === "true"){
          $('#profiles').slideUp();
          $(this).attr('opened', 'false');
          $(this).find('.toggle-arrow').css('transform', 'rotateZ(0)');
        }
        else{
          $('#profiles').slideDown();
          $(this).attr('opened', 'true');
          $(this).find('.toggle-arrow').css('transform', 'rotateZ(180deg)');
        }
    })

    // hide comments and profiles sections by deafault
    $('.post').find('h6').each(function(){
      $(this).parent().next().hide();
      $(this).next().hide();
    })
    $('#profiles').hide();
});
