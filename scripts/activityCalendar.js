$(document).ready(function(){
  var calendarDisplayFromDaysAgo = 0;

  function createCalendar(daysAgoStart){
      let calendar = $('#calendar');
      calendar.empty();
      let userActiveDays = $('#calendar').attr('data-active-dates').trim();
          userActiveDays = userActiveDays.split(" ");
      let date = new Date();
          date.setDate(date.getDate() - daysAgoStart);
      let dateYMD;
      for (var i = 0; i < 30; i++) {
        let classes = "activityDay";
        dateYMD = date.toISOString().split('T')[0];
        if(userActiveDays.indexOf(dateYMD) !== -1) classes += ' dayChecked';
        calendar.append(`<div class="${classes}" title='${dateYMD}'></div>`)

        date.setDate(date.getDate() - 1);
      }
      $('#calendar-time-range').html(`${daysAgoStart} - ${daysAgoStart+30} dni temu`)
  }

  createCalendar(calendarDisplayFromDaysAgo);
  $("#nextMonthBtn").click(() => {
    if(calendarDisplayFromDaysAgo>0){
      calendarDisplayFromDaysAgo-=30;
      createCalendar(calendarDisplayFromDaysAgo);}
    });

  $("#prevMonthBtn").click(() => {
    calendarDisplayFromDaysAgo+=30;
     createCalendar(calendarDisplayFromDaysAgo);
   });
})
