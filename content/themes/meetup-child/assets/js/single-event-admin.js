var $ = jQuery.noConflict();

$(function() {
  AdminView.hideUseless();
  AdminView.checkSpotsLimit();
  AdminView.changeTexts();
  AdminView.handleNotes();
});

var AdminView = {
  loader: $("<div class='mini-loader uil-spin-css' style='-webkit-transform:scale(0.18)'><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div>"),
  loaderDone: $('<div class="loader-done">').html('<span class="dashicons dashicons-yes"></span>'),
  loaderFailed: $('<div class="loader-done loader-failed">').html('<span class="dashicons dashicons-no-alt"></span>'),
  handleNotes: function() {
    var self = this;
    $('.user-note').on('change focusout', function(event) {
      var input = $(this);
      var val = $(this).val();
      var userId  = $(this).data('user');
      var eventId = $(this).data('event');

      $(this).parent().append(self.loader.show());

      $.ajax({
        type: "POST",
        url: ajaxurl,
        data: {
          action: 'handle_notes',
          user_id: userId,
          event_id: eventId,
          content: val
        }
      })
        .fail(function(data, status) {
          setTimeout(function() {
            input.parent().find('.mini-loader').fadeOut('fast', function() {
              $(this).remove();
              input.parent().append(self.loaderFailed.show()).delay(800).queue(function(next){
                input.parent().find('.loader-done').fadeOut(function() {
                  $(this).remove();
                });
              });
            });
          }, 1200);
        })
        .done(function(data, status) {
          setTimeout(function() {
            input.parent().find('.mini-loader').fadeOut('fast', function() {
              $(this).remove();
              input.parent().append(self.loaderDone.show()).delay(800).queue(function(next){
                input.parent().find('.loader-done').fadeOut(function() {
                  $(this).remove();
                });
              });
            });
          }, 1200);
        });

    });
  },
  changeTexts: function() {
    var base = $('.post-type-tribe_events');
    base.find("#tribe_events_event_details h2 span").text('Paramètres de la session');
  },
  checkSpotsLimit: function() {
    if ($('input#EventSpotsLimit').val() < 3) {
      $('input#EventSpotsLimit').val(3);
    }

    $('span.event-spot-limit-value').text($('input#EventSpotsLimit').val());

    $('input#EventSpotsLimit').on('keyup change', function(e) {
      $('span.event-spot-limit-value').text($(e.target).val());
    });

  },
  hideUseless: function() {
    var base = $('.post-type-tribe_events');
    base.find("#post-body-content .postarea").slideUp();
    //base.find("#titlediv").after('<h2 class="session-prog">Programme de la session</h2>').hide();

    base.find('#event_organizer, #event_url, #event_cost, #postexcerpt, #postcustom, #commentstatusdiv, #commentsdiv, #slugdiv, #authordiv, #event_venue').hide();

    base.find(".event-timezone").hide();

  }
}
