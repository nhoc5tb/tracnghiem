<header class="p-1 pt-3 text-center border-b-[1px] border-gray-300">
    <a href="<?php echo base_url() ?>" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Ôn Bài</a>
    <a href="<?php echo base_url() ?>trac-nghiem" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Làm Trắc Nghiệm</a>
    <button id="clear" type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Clear</button>
  </header>
  <main class="">
    <input type="hidden" value="" id="nextQue">
  <?php foreach ($getcsdl as $key => $value):?>
    <section class="container mx-auto max-w-3xl px-4 lg:px-0 py-2 <?php echo ($key == 0)?"":"hidden"; ?>" id="ques<?php echo $value->id ?>">
      <div class="bg-box">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Câu : <?php echo $value->id ?></h5>
        <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo substr($value->question, 2) ?></p>
      </div>  
      <div class="grid">
        <?php 
        $bg = "xanh";
        foreach ($value->answer as $_key => $_value):
          switch ($_value->answer[0]) {
            case 'A':
              $bg = "xanh";
              break;
            case 'B':
              $bg = "vang";
              break;
            case 'C':
              $bg = "tim";
              break; 
            case 'D':
              $bg = "nuocbien";
              break;   
            default:
              # code...
              break;
          }
        ?>
        <div class="bg-box-sub btn-chon" data-question="<?php echo $value->id ?>" data-answer="<?php echo $_value->id ?>" data-correct="<?php echo $_value->correct ?>">
          <div class="flex">
            <div class="<?php echo $bg ?> py-3 w-14 font-bold text-2xl text-center text-white"><?php echo $_value->answer[0] ?></div>
            <div class="flex-1 p-2 justify-center"><?php echo substr($_value->answer, 2) ?></div>
          </div>
        </div>
        <?php endforeach ?>  
      </div>   
    </section>
  <?php endforeach ?>
    <div class="mt-4 p-4 pt-0">
      <button id="next-question" type="button" class="px-6 py-3.5 text-base font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Câu Tiếp Theo ...</button>
    </div> 
  </main>
  <div id="msg-modal" tabindex="-1" aria-hidden="true" class="fixed flex hidden backdrop-blur-sm bg-white/40 top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-full max-h-full justify-center items-center ">
    <div class="relative w-full max-w-md max-h-full">
      <div class="relative rounded-lg shadow bg-gray-100 dark:bg-gray-700">             
        <div class="px-6 py-4 border-b rounded-t dark:border-gray-600"><h3 class="text-lg font-semibold text-gray-900 lg:text-xl dark:text-white"> Kết Quả </h3></div>
          <div class="p-6">
            <p class="text-sm font-normal text-gray-400 text-center">Số điểm là</p>
            <div class="text-center mt-4"> 
                <h3 class="text-5xl font-semibold text-gray-900 lg:text-xl dark:text-white"> <span id="point" data-count="<?php echo count($getcsdl) ?>">0</span>/<span id="count"><?php echo count($getcsdl) ?></span> </h3>
                <button id="btn-hoanthanh" type="button" class="mt-4 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Đang ghi dữ liệu ...</button>
            </div>
            <div class="flex mt-4"> 
              <p class="text-xs font-normal text-gray-500 dark:text-gray-400">
                    * Trả lời đúng 2 lần trong ôn tập, sẽ không dùng câu hỏi đó trong trắc nghiệm. <br>
                    * Muốn dùng lại chọn chức năng CLEAR</p>
          </div>
        </div>    
      </div>
    </div>
  </div>
  <script type="text/javascript">   
    $(document).ready(function () {
      traLoi();
      nextQues();
    });
    function traLoi(){
      //chiêu trò lại cho section là id thứ tự đo php tạo rồi button câu trả lời truy suất lại, chứ cách gọi lại này ko ổn
      $('.btn-chon').click(function () {
        var _this = $(this); 
        let parent = _this.parents("section"); 
        $("input#nextQue").val("#ques"+_this.attr("data-question"));//nạp cậu hiện tại đang làm để nextQues() sài lại
        parent.find(".btn-chon").removeClass("active");
        _this.addClass("active"); 
        //show đáp án
        let correct = parent.find('.bg-box-sub.btn-chon.active').attr("data-correct");
        if(correct == 0){
          parent.find("[data-correct='1']").addClass("active-fail");
        }       
        //show đáp án             
      });
    }
    function nextQues(){ 
      $('#next-question').click(function () { 
        let nextQues = $($('input#nextQue').val()); 
        _this = $(this);           
        let nextParent = nextQues.next('section'); 
        nextQues.hide();
        nextParent.removeClass("hidden");
        checkPoint();
      });
    }
    function checkPoint(){
      //tính điểm
      let point = 0;
      $('.bg-box-sub.btn-chon.active').each(function () {
        let correct = $(this).attr("data-correct");
        if(correct == 1){
          point++;
        }
        $("#point").text(point);
      });

      let cauDaLam = $("#point").attr("data-count");
      if(cauDaLam == 1){
        $("#msg-modal").removeClass("hidden");
        napDiem();
        return;
      }
      //tinh số câu đã trả lời
      cauDaLam--;
      $("#point").attr("data-count",cauDaLam);
    }
    function napDiem(){
      let point = [];
      $('.bg-box-sub.btn-chon.active').each(function () {
        let correct = $(this).attr("data-correct");
        if(correct == 1){
          point.push($(this).attr("data-question"));
        }
      });
      if (!point.length) {
        $("#btn-hoanthanh").html("Ôn Lại");
        $('#btn-hoanthanh').click(function () {
              window.location.href = '<?php echo base_url() ?>';
        });
        return;
      }

      fd = new FormData();
      fd.append('point',point);
      $.ajax({
        url: "<?php echo base_url() ?>napdiem",
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
          if(data.status == 200){                    
            $("#btn-hoanthanh").html("Ôn Lại");
          }else{
            $("#btn-hoanthanh").html("Lỗi ! Vui lòng làm lại");
          }
          $('#btn-hoanthanh').click(function () {
              window.location.href = '<?php echo base_url() ?>';
          });
        },error: function() { }
      });
    }
  </script>