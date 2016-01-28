if (!$) {
  var $ = jQuery;
}

$(function() {
  $('#user_phone').attr('type', 'tel');
  $('input[type=tel]').attr('pattern', "^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$");

  // Hide the username
  $('.wpum-registration-form .fieldset-username').hide();

  // Set the username to the email
  $('.wpum-registration-form').on('change, keyup', 'input[name="user_email"]', function(e) {
    var email = $(e.currentTarget).val();
    var username = $(this).parents('form').find('input[name="username"]');
    username.val(email);
  });


});
