<link href="<?php echo base_url() ?>assets/css/bootstrap-imageupload.css" rel="stylesheet">
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>"><?php echo $controller_title ?></a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="row">
  <form action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed" method="post" enctype="multipart/form-data">
            <div class="col-md-8">
              <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading panel-heading-divider"><?php echo $title ?><span class="panel-subtitle">Thêm nội dung cho website</span></div>
                <div class="panel-body">
                	<?php if (validation_errors()):?>					
                    <div role="alert" class="alert alert-contrast alert-danger alert-dismissible">
                        <div class="icon"><span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message">
                          <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button>
                          <?php if (validation_errors()) echo validation_errors(' ','<br>'); ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Tiêu đề</label>
                      <div class="col-sm-10">
                        <input id="title" name="title" value="<?php echo set_value('title');?>" parsley-trigger="change" required="" placeholder="Tiêu đề" autocomplete="on" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Thẻ H1</label>
                      <div class="col-sm-10">
                        <input id="title" name="headingh1" value="<?php echo set_value('headingh1');?>" parsley-trigger="change" placeholder="Nếu rỗng sẽ lấy tiêu đề" class="form-control" type="text">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Slug</label>
                      <div class="col-sm-10">
                        <input placeholder="Slug cho seo" class="form-control" name="slug" value="<?php echo set_value('slug');?>" type="text">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Chuyên mục</label>
                      <div class="col-sm-10">
                      	<select class="select2" name="catalog">
                              <?php	foreach($catalogs as $row){
									echo '<option value="'.$row->id.'" '.set_select('catalog', $row->id, (!empty($this->input->cookie('tmp_catalog',true)) && $this->input->cookie('tmp_catalog',true) == $row->id)).'>'.$row->title.'</option>';
								}
							?>
						  </select>
                      </div>
                    </div>
                                  
                    <?php $this->load->view("blockmodule/upfile.php",array("size"=>2));?>   
                    <div class="form-group">
                      <label class="col-sm-2 control-label">Mô tả</label>
                      <div class="col-sm-10">
                        <textarea class="form-control" id="home_text" name="home_text" rows="4"></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-md-4">
                            <label class="control-label">Chọn Ngôn Ngữ Của Bạn:</label>
                            <select id="selLang" class="form-control">
                                <option value="vi-VN">Tiếng Việt</option>
                                <option value="en-US">Tiếng Anh US</option>
                            </select> 
                          </div>  
                          <div class="col-md-4">
                            <label class="control-label">Kiểu Dữ Liệu Hiển Thị</label>
                              <select id="selModel" class="form-control col-md-3">
                                <option value="text-davinci-003" title="text-davinci-003">Mặc Định (davinci-003)</option>
                                <option value="text-davinci-002" title="text-davinci-002">Văn Bản (davinci-002)</option>
                                <option value="code-davinci-002" title="code-davinci-002">Code (davinci-002)</option>
                            </select>
                          </div>
                          <div class="col-md-4">  
                          <label class="control-label" style="with:100%;display: block;text-align: left;">Dùng chatGPT lấy mô tả theo tiêu đề</label>
                            <button type="button" class="btn btn-success btn-lg" onclick="quesGPT()" id="btnSend">Dùng ChatGPT</button>
                          </div>  
                        </div>  
                        
                      </div>
                    </div>
                    <script>
                      var Key_OpenAI = "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";
                      function quesGPT(){
                        var txtOutput = document.querySelector("#home_text");
                        var sQuestion = document.querySelector("#title").value;
                        if (sQuestion == "") {                           
                            txtMsg.focus();
                            return;
                        }
                        document.querySelector("#btnSend").textContent = "Đang viết ...";
                        var DataPost = new XMLHttpRequest();
                        DataPost.open("POST", "https://api.openai.com/v1/completions");
                        DataPost.setRequestHeader("Accept", "application/json");
                        DataPost.setRequestHeader("Content-Type", "application/json");
                        DataPost.setRequestHeader("Authorization", "Bearer " + Key_OpenAI)
                        DataPost.onreadystatechange = function() {
                        if (DataPost.readyState === 4) {
                                var oJson = {}
                                try {
                                    oJson = JSON.parse(DataPost.responseText);
                                } catch (ex) {
                                    txtOutput.value += "\nLỗi: " + ex.message;
                                    document.querySelector("#btnSend").textContent = "Lỗi : Thử lại";
                                }
                                if (oJson.error && oJson.error.message) {
                                    txtOutput.value += "\mLỗi: " + oJson.error.message;
                                    document.querySelector("#btnSend").textContent = "Lỗi : Thử lại";
                                } else if (oJson.choices && oJson.choices[0].text) {
                                    var s = oJson.choices[0].text;
                                    if (selLang.value != "vi-VN") {
                                        var a = s.split("?\n");
                                        if (a.length == 2) {
                                            s = a[1];
                                        }
                                    }
                                    if (s == "") s = "Không Có Phản Hồi";
                                    txtOutput.value += s.trim();
                                    document.querySelector("#btnSend").textContent = "Dùng ChatGPT";
                                }
                            }
                        };
                        var sModel = selModel.value; //Mặc Định: "text-davinci-003";
                        var iMaxTokens = 2048;//số từ trả về
                        var sUserId = "1";
                        var dTemperature = 0.5;
                        var data = {
                            model: sModel,
                            prompt: sQuestion,
                            max_tokens: iMaxTokens,
                            user: sUserId,
                            temperature: dTemperature,
                            frequency_penalty: 0.0,
                            presence_penalty: 0.0,
                            stop: ["#", ";"]
                        }
                        DataPost.send(JSON.stringify(data));
                        if (txtOutput.value != "") txtOutput.value += "\n";                          
                      }
                                       
                    </script>
                    <div class="form-group">
                      <div class="col-sm-12">		
                      <?php 
                        $content =  set_value('body_text');	
                      $this->load->view("blockmodule/froalaeditor.php",array("name"=>"body_text","content_froalaeditor"=>$content));
                      ?>
                      </div>
                    </div>
                                         
                    
                    <div class="form-group">
                      <label class="col-sm-2 control-label"></label>
                      <div class="col-sm-10">
                      		<button class="btn btn-primary btn-lg" type="submit">Thêm Bài Viết</button>
							            <button class="btn btn-default btn-lg" type="button">Nhập Lại</button>  
                      </div>
                    </div>
                    
                    
                  
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="panel panel-default panel-border-color panel-border-color-primary">    
                <div class="panel-heading panel-heading-divider">Thêm Trang Tin<span class="panel-subtitle">Thêm nội dung cho website</span></div>     
                <div class="panel-body">
                  <div class="form-group">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                      <textarea class="form-control" name="description"></textarea>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            </form>            
          </div>
         