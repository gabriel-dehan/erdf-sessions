if (!$) {
  var $ = jQuery;
}

$(function() {
  // Hide the username
  $('.wpum-registration-form .fieldset-username').hide();

  // Set the username to the email
  $('.wpum-registration-form').on('change, keyup', 'input[name="user_email"]', function(e) {
    var email = $(e.currentTarget).val();
    var username = $(this).parents('form').find('input[name="username"]');
    username.val(email);
  });
});
