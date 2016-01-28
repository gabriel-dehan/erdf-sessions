if (!$) {
  var $ = jQuery;
}

$(function() {
  $("#home-calendar").load("/events #tribe-events-calendar")

  $(".ecs-event a").html($(".ecs-event .tribe-event-date-start").html())
  var text = $(".ecs-event a").text();
  $(".ecs-event a").text(text.replace(/de .*/, ''));
  $(".ecs-event p").hide();
});
