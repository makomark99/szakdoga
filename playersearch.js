type="text/javascript">

$(document).ready( async function(){
  $("#search").keyup(function(){
    let value=$("#search").val().trim();
    function showSpinner(){
      document.getElementById('spinner').classList.remove("d-none");
    }
    function hideSpinner(){
      document.getElementById('spinner').classList.add("d-none")
    }
    showSpinner();
    setTimeout(function(){
      if($("#search").val().trim()==value){
        $.ajax({
          type:'POST',
          url: 'livesearch.php',
          data:{
            name: $("#search").val().trim(),
          },
            success:function(data){        
              $("#output").html(data);
            }
        });
      }
      hideSpinner();
    },1100);
  });
});

