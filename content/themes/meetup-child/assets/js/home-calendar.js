
if (!$) {
  var $ = jQuery;
}

$(function() {
  $("#home-calendar").load("/events #tribe-events-calendar")

  $(".ecs-event a").html($(".ecs-event .tribe-event-date-start").html())
  var text = $(".ecs-event a").text();
  $(".ecs-event a").text(text.replace(/de .*/, ''));
  $(".ecs-event p").hide();

  // Hide them all
  $(".speaker-description .text-link").hide();
  // Only display when there actually is a description
  $(".speaker-description p + .text-link").show().text("Lire la suite");
});
