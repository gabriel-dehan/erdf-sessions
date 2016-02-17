if (!$) {
  var $ = jQuery;
}

$(function() {
  $('#user_phone').attr('type', 'tel');

  $('input[type=tel]').on('blur', function(e) {
    var tel = $(e.target).val();
    $(e.target)[0].setCustomValidity("");

    if (!tel.match(/^(\+33|0)\s?[67]([ .\-]?[0-9][ .\-]?){8}$/)) {
      $(e.target)[0].setCustomValidity("Votre numéro de téléphone est incorrect");
    }
  });

  // Hide the username
  $('.wpum-registration-form .fieldset-username').hide();

  // Set the username to the email
  $('.wpum-registration-form').on('change, keyup', 'input[name="user_email"]', function(e) {
    var email = $(e.currentTarget).val();
    var username = $(this).parents('form').find('input[name="username"]');
    username.val(email);
  });


});
