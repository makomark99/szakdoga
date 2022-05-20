type="text/javascript">
$(document).ready(function(){
  $("#search").keyup(function(){
    $.ajax({
      type:'POST',
      url: 'livesearch.php',
      data:{
        name: $("#search").val(),
      },
        success:function(data){
          $("#output").html(data);
        }
    });
  });
});

