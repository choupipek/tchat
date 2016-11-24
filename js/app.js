$('input').on('change', function(event){
  event.preventDefault();
  var data = $(this).val()
  console.log(data);
  if(data.lenght < 3){
    $('input').css('border', '1px solid red');
  }
});
