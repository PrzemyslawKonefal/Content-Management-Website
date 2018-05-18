
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
    if(trigger.css("bottom") === "0px") {
      trigger.animate({"bottom": "-200px"}, 1000);
      form.animate({"bottom": "-200px"}, 1000);
    }
    else{
      trigger.animate({"bottom": "0px"}, 1000);
      form.animate({"bottom": "0px"}, 1000);
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
    console.log(2);
  }
  for(let i = 0; i<3; i++)  placeImageToPost(i);

});
