$('#user_random').on('click', function(event){
  event.preventDefault();
  $.ajax({
    url: 'get_one_user.php',
    method: 'GET',

    beforeSend: function() {
      $('#user_random').fadeOut(500);
    },

    success: function(data) {
      $('.user').fadeOut(2);
      var $user = $('<div>').addClass('user').text(data.toUpperCase());
      $('.alert-success').append($user);
    },

    error: function() {
      console.log('ERROR');
    }
  })
  .done( function() {
    $('#user_random').fadeIn(500);

  })

});

function reloading(){
  $.ajax({
    url: 'get_message.php',
    method: 'GET',
    success: function(response) {
      $('#tchat').prepend(response);
    },

    error: function() {
      console.log('error');
    }
  })
}


$('#form_tchat').on('submit', function(event){
  event.preventDefault();
  var $data = $("#message").val();

  $.ajax({
    url: 'post_message.php',
    method: 'POST',
    data: {
      'message' :  $data
    },

    success: function(data) {

    },

    error: function() {
      console.log('error');
    }
  })

  $("#message").val('');

})

$('#form_inscription').on('submit', function(event){
  event.preventDefault();
  var form = $('#form_inscription');
  $('#pseudo_error').empty();
  $('#email_error').empty();
  $('#password_error').empty();
  $('#password_repeat_error').empty();

  $.ajax({
    type: "POST",
    url: 'inscription_verif.php',
    data: form.serialize(),
    dataType: "json",

    success: function(response){

      console.log(response.success);
      if(response.success === true){
        $('#form_inscription').fadeOut(1000);
        $('#success').append('Inscription réussite ! Penser à cliquer sur le lien envoyé à votre adresse mail pour valider votre compte !')
      }
      else{
        $('#pseudo_error').append(response.error['pseudo']);
        $('#email_error').append(response.error['email']);
        $('#password_error').append(response.error['password']);
        $('#password_repeat_error').append(response.error['repeat_password']);
      }
    }
  })
})

$('#form_connexion').on('submit', function(event){
  event.preventDefault();
  var formConnexion = $('#form_connexion');

  $('#login_error').empty();
  $('#password_error').empty();

  $.ajax({
    type: "POST",
    url: 'connexion_verif.php',
    data: formConnexion.serialize(),
    dataType: "json",

    success: function(response){

      console.log(response.success);

      if(!response.success){
        $('#login_error').append(response.error['login']);
        $('#password_error').append(response.error['password']);
      }
      else if(response.success){
        window.location.href="index.php";
      }
    }
  });
})
if ($( "#form_tchat" ).length) {
    setInterval(reloading, 1500);
}


$('#tchat').on('mouseenter', '.news', function(event){
  event.preventDefault();
  $(this).removeClass('news');
})
