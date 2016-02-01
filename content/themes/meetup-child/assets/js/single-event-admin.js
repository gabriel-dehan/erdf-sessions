var $ = jQuery.noConflict();

$(function() {
  var base = $('.post-type-tribe_events');
  base.find("#post-body-content .postarea").slideUp();
  //base.find("#titlediv").after('<h2 class="session-prog">Programme de la session</h2>').hide();

  base.find('#event_organizer, #event_url, #event_cost, #postexcerpt, #postcustom, #commentstatusdiv, #commentsdiv, #slugdiv, #authordiv, #event_venue').hide();

  base.find(".event-timezone").hide();

  if ($('input#EventSpotsLimit').val() < 3) {
    $('input#EventSpotsLimit').val(3);
  }

  base.find("#tribe_events_event_details h2 span").text('Paramètres de la session');

  $('span.event-spot-limit-value').text($('input#EventSpotsLimit').val());
  $('input#EventSpotsLimit').on('keyup change', function(e) {
    $('span.event-spot-limit-value').text($(e.target).val());
  });

});
