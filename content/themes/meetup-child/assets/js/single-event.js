var $ = jQuery.noConflict();

$(function() {
  if ($('input#EventSpotsLimit').val() < 3) {
    $('input#EventSpotsLimit').val(3);
  }
  $('span.event-spot-limit-value').text($('input#EventSpotsLimit').val());
  $('input#EventSpotsLimit').on('keyup change', function(e) {
    $('span.event-spot-limit-value').text($(e.target).val());
  });

  var base = $('.post-type-tribe_events');
  base.find("#titlediv").after('<h2 class="session-prog">Programme de la session</h2>');

  base.find('#event_organizer, #event_url, #event_cost, #postexcerpt, #postcustom, #commentstatusdiv, #commentsdiv, #slugdiv, #authordiv').hide();
});
