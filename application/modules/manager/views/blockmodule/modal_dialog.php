 <!--Thông báo xóa -->
<div id="md-footer-danger" tabindex="-1" role="dialog" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
          </div>
          <div class="modal-body">
            <div class="text-center">
              <div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
              <h3>Cảnh Báo !</h3>
              <p class="msg">Bạn có thực sử muốn xóa</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Không</button>
            <button type="button" data-dismiss="modal" class="btn btn-danger rbtn-ajaxdelete"  data-path="" >Đúng ! Tôi muốn thực hiện</button>
          </div>
        </div>
    </div>
</div>
<!--Thông báo xóa--> 
<script type="text/javascript">
  $(document).ready(function(){
    $.extend($.gritter.options, { position: 'bottom-right' });
    $(".status").click(function(e){     
      let idinput = $("#"+$(this).attr("for"));
      fd = new FormData();
      fd.append('ru_csrf_token_name',ru_csrf_token_name);
      fd.append('id',$(this).attr("data-id"));
      $.ajax({
        url: $(this).attr("data-path"),
        data: fd, 
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        beforeSend:function(){
          if(idinput.attr("checked") == "checked"){
            idinput.removeAttr("checked");
          }else{
            idinput.attr("checked","checked");
          } 
        },
        success: function(data){        
          if(data.status != 200){
            $.gritter.add({
              title: 'Thông Báo',
              text: data.msg,
              class_name: 'clean'
            });
            if(idinput.attr("checked") == "checked"){
              idinput.removeAttr("checked");
            }else{
              idinput.attr("checked","checked");
            } 
          }
        },
        complete:function(){},
        statusCode: {
            404: function(){
              $.gritter.add({
              title: "Thông báo",
              text: "Lỗi 404",
              class_name: 'clean'
            });               
            },
            403: function(){    
              $.gritter.add({
              title: "Thông báo",
              text: "Lỗi 403",
              class_name: 'clean'
            });     
            if(idinput.attr("checked") == "checked"){
              idinput.removeAttr("checked");
            }else{
              idinput.attr("checked","checked");
            }       
            }
        },
        error: function() {   
        }     
      });//$.ajax 
      e.preventDefault();   
    });
    //del Button
    $.fn.niftyModal('setDefaults',{
          overlaySelector: '.modal-overlay',
          closeSelector: '.modal-close',
          classAddAfterOpen: 'modal-show',
    });
    $('.btn-delete').click(function(e){   
      $("#md-footer-danger .rbtn-ajaxdelete").attr("data-path",$(this).attr("data-path"));
      $("#md-footer-danger .rbtn-ajaxdelete").attr("data-id",$(this).attr("data-id"));
      $("#md-footer-danger .msg").html($(this).attr('msg'));
      e.preventDefault();
    }); 
    $(".rbtn-ajaxdelete").click(function(e){
      let _this = $(this);
      fd = new FormData();
      fd.append('ru_csrf_token_name',ru_csrf_token_name);
      fd.append('id',_this.attr("data-id"));
      $.ajax({
        url: _this.attr("data-path"),
        data: fd, 
        type: 'POST',
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
          $.gritter.add({
            title: 'Thông Báo',
            text: data.msg,
            class_name: 'color danger'
          });
          if(data.status == 200){         
            let _remove = $("#id"+data.callback);
            _remove.fadeOut();                  
          }
        },
        error: function() { 
          console.log('Lỗi truy vấn');          
        }
      });//$.ajax
            
      e.preventDefault();
    });
    //#del Button
  });
</script>