
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
      const maxDate = new Date().toISOString().split("T")[0];
      $("body").append(`
        <form id='posting-box' action='scripts/server/addWorkout.php' method='post'>
          <span id = 'close'>X</span>
          <p>Data</p>
          <input id="date" name="date" type="date" value="${maxDate}" max="${maxDate}" min ="2018-04-01" required>
          <p>Czas treningu</p>
          <input type='number' name='time' min='10' required>
          <p>Rodzaj treningu</p>
          <select name='type' required>
          <option selected="true" disabled="disabled" hidden></option>
          <option value='Split'>Split</option>
          <option value='FBW'>FBW</option>
          <option value='Kalistenika'>Kalistenika</option>
          <option value='Cardio'>Cardio</option>
          <option value='Inne'>Inne</option>
          </select>
          <p>Opis</p>
          <textarea name='description'></textarea>
          <input type='submit' value='Dodaj'>
        </form>`);
    }
  })

const countAnimation = function(JquerySelector, time, speed = 1){
   let value = JquerySelector.html();
   let valueCounter = 0;
   let frameChangeTime = time/value;
   let interval = setInterval(function(){
       JquerySelector.text(valueCounter);
       if(valueCounter+speed >= value) {JquerySelector.text(value);clearInterval(interval)};
       valueCounter+=speed;
   }, frameChangeTime);
}
countAnimation($('#landing h1').eq(0), 2000);
countAnimation($('#landing h1').eq(1), 2000, 10);

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
    $('body').on('click', '.post h6', function(){
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
    });

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


    // Like hit for comments and posts
    $('body').on('click', '.comment .thumb', function(){
        if($('body > data').attr('value') != '1') return;
        const id = $(this).parent().find('data').attr('value');
        let span = $(this).parent().find('span');
        span.html(parseInt(span.html())+1);
        $.post('scripts/server/likePP.php', {table: "comments", commentId: id});
        $(this).unbind('click');
        $(this).css('cursor','auto');
        return;
        });

    $('body').on('click', '.post-description .thumb', function(){
            if($('body > data').attr('value') != '1') return;
            const id = $(this).parent().parent().find('input:last').attr('value');
            let span = $(this).parent().find('span');
            span.html(parseInt(span.html())+1);
            $.post('scripts/server/likePP.php', {table: "workouts", commentId: id});
            $(this).unbind('click');
            $(this).css('cursor','auto');
            return;
        });
    $('body').on('click', '.settings-trigger-box', function(){
      const time = $(this).parent().find('.post-stat-time').html();
      const type = $(this).parent().find('.post-stat-type').html();
      const date = $(this).parent().find('.post-link').html();
      const maxDate = new Date().toISOString().split("T")[0];
      const postID = $(this).parent().find('.post-link').attr('href').split('=')[1];
      let description = $(this).parent().find('.post-description').html();
          description = description.substr(0, description.indexOf("<br>")).trim();
      $("body").append(`
        <form id='posting-box' action='scripts/server/addWorkout.php' method='post'>
          <span id = 'close'>X</span>
          <p>Data</p>
          <input id="date" name="date" type="date" value="${date}" max="${maxDate}" min ="2018-04-01" required>
          <p>Czas treningu</p>
          <input type='number' name='time' min='10' value="${time}" required>
          <p>Rodzaj treningu</p>
          <select name='type' required>
          <option selected="true" value ="${type}" hidden>${type}</option>
          <option value='Split'>Split</option>
          <option value='FBW'>FBW</option>
          <option value='Kalistenika'>Kalistenika</option>
          <option value='Cardio'>Cardio</option>
          <option value='Inne'>Inne</option>
          </select>
          <p>Opis</p>
          <textarea name='description'>${description}</textarea>
          <input name='postID' value ='${postID}' hidden>
          <input type='submit' value='Zmień'>
        </form>`);
    });
});
