
$(document).ready(function(){

  const trainingsCount = [];
  const timeCount = [];
  const userWorkoutAmount = $('#workoutAmount .single-data');
  const userTimeSpent = $('#timeSpent .single-data');
  const trigger = $("#loginTrigger");
  const form = $("#logForm");
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

  var logToggle = function(){
    if((form.css("z-index") === "10") || form.length === 0) {
      form.css('z-index', '-10');
      form.animate({"bottom": "-200px", "opacity": "0"}, 1000);
    }
    else{
      form.css('z-index', '10');
      form.animate({"bottom": "0px", "opacity": "1"}, 1000);
    }
  }
  trigger.click(() => logToggle());

  $("body").on('click', '#close', function(){
    if(trigger.length>0) logToggle();
    else $('#close').parent().remove();
  })

  const addPost = $("#add-post");
  addPost.click(function(){
    if($('#posting-box').length === 0){
    $("body").append(`<form id='posting-box' action='scripts/server/addWorkout.php' method='post'><span id = 'close'>X</span><p>Czas treningu</p><input type='number' name='time' min='10' required><p>Rodzaj treningu</p><select name='type' required>
      <option selected="true" disabled="disabled" hidden></option>
      <option value='Split'>Split</option>
      <option value='FBW'>FBW</option>
      <option value='Kalistenika'>Kalistenika</option>
      <option value='Cardio'>Cardio</option>
      <option value='Inne'>Inne</option>
      </select><p>Opis</p><textarea name='description'></textarea><input type='submit' value='Dodaj'></form>`);
    }
  })

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
for(let i = 0; i<2; i++) countAnimation($('#landing h1').eq(i), 2000);

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
        return;
    })

    // hide comments and profiles sections by deafault
    $('.post').find('h6').each(function(){
      $(this).parent().next().hide();
      $(this).next().hide();
      return;
    })
    $('#profiles').hide();
});
    // Like hit for comments and posts
    $('.comment .thumb').click(function(){
        if($('body > data').attr('value') != '1') return;
        const id = $(this).parent().find('data').attr('value');
        let span = $(this).parent().find('span');
        span.html(parseInt(span.html())+1);
        $.post('scripts/server/likePP.php', {table: "comments", commentId: id});
        $(this).unbind('click');
        $(this).css('cursor','auto');
        return;
        });

    $('.post-description .thumb').click(function(){
            if($('body > data').attr('value') != '1') return;
            const id = $(this).parent().parent().find('input:last').attr('value');
            let span = $(this).parent().find('span');
            span.html(parseInt(span.html())+1);
            $.post('scripts/server/likePP.php', {table: "workouts", commentId: id});
            $(this).unbind('click');
            $(this).css('cursor','auto');
            return;
        });
