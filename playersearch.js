type="text/javascript">

$(document).ready( function(){
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





//How to paginate AJAX live search results in php?  
/*$(document).ready(function() {
  change_page('0');
});

function change_page(page_id) {
  //To get the field value
  var search_val = $("#search_box").val();
  $(".flash").show();
  $(".flash").fadeIn(400).html('Loading <img src="ajax-loader.gif" />');
  var dataString = 'page_id=' + page_id + '&search=' + search_val;
  $.ajax({
    type: "POST",
    url: "paging.php",
    data: dataString,
    cache: false,
    success: function(result) {
      $(".flash").hide();
      $("#page_data").html(result);
    }
  });
}*/