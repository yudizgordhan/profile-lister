require([
    'jquery'
    ],function($){

      $(document).ready(function() {

      $(".btn-add-more").click(function(){ 
          $(".img_div").after(
              `<div class="clone hide">
                <div class="control-group input-group">
                  <input type="file" name="multiple_image[]" accept="image/*" id="multiple_image" />
                  <div class="input-group-btn"> 
                    <button class="btn btn-danger btn-remove" type="button"><i class="glyphicon glyphicon-remove"></i>-</button>
                  </div>
                </div>
              </div>`
          );
      });

      $("body").on("click",".btn-remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });
});

