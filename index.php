<!DOCTYPE html>
<html>
 <head>
  <title></title>  
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 </head>
 <body> 
   <div class="container">
    <div class="progress">
      <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="">
    </div>
    <div id="progressbar"></div>
   </div>
   <input type="button" value="Run data" class="btn">
   <div class="rows"></div>
  
 </body>
</html> 

<script>
 
 $(document).ready(function(){ 
    $(".btn").click(function(){
      $.ajax({
      url:"_transaction.php",
      method:"POST", 
      success:function(data)
      { 
          let jmlcurrent = JSON.parse(data).total_currently;
          $( "#progressbar" ).progressbar({
              value: jmlcurrent
          }); 
          $(".btn").hide()
      }
      })
    })
    
    $(".rows").load('_result.php');

 });
</script>

