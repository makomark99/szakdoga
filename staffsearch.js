type="text/javascript">
$(document).ready(function(){
  $("#search2").keyup(function(){
    $.ajax({
      type:'POST',
      url: 'staffsearch.php',
      data:{
        name: $("#search2").val(),
      },
        success:function(data){
          $("#output2").html(data);
        }
    });
  });
});