var $ = jQuery.noConflict();

$(function() {
  var base = $('.post-type-tribe_events');
  base.find("#titlediv").after('<h2 class="session-prog">Programme de la session</h2>');

  base.find('#event_organizer, #event_url, #event_cost, #postexcerpt, #postcustom, #commentstatusdiv, #commentsdiv, #slugdiv, #authordiv').hide();
});
