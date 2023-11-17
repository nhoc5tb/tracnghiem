<script type="text/javascript">
	function addVariant(){
		$(".ru-variant-box").append('<button id="addvariant" class="btn btn-space btn-primary btn-lg" style="height: 47px;">Thêm Biến Thể</button>'); 
		$("#addvariant").click(function(e){
			var d = new Date();//thêm thời gian lúc nhấn cho tránh trùng lặp
  			var n = d.getTime();
			var string = $("#temp_ru-list-variant").text();
			var name = "";
			var id_name = "ru-";
			var data_id = "";
			var tmp = [];
			var tmp2 = [];
			$(".select3").each(function(){
				let select2 = $(this).select2('data');
				tmp.push(select2[0].text);
				tmp2.push(select2[0].id);
			});
			name = tmp.join(",");
			data_id = 'data-id="'+tmp2.join(",")+'"';
			id_name += tmp2.join("-")+n;			
			//loại bỏ trung
			/*
			var myDiv = $("#"+id_name+n);
		    if (myDiv.length > 0){
		    	$.gritter.add({
		    		title: 'Thông Báo',
		    		text: 'Thuộc tính này đã được sử dụng',
		    		class_name: 'color danger'
		    	});
		    	e.preventDefault();
		    	return;
		    }
		    */
		    //loại bỏ trung
			string = string.replace("%%name%%",name);
			string = string.replace("%%name%%",name);

			string = string.replace("%%data_id%%",data_id);
			string = string.replace("%%data_id%%",data_id);

			string = string.replace("%%id_name%%",id_name);
			string = string.replace("%%id_name%%",id_name);
			string = string.replace("%%id_name%%",id_name);
			string = string.replace("%%id_name%%",id_name);

			var id_file = Math.random().toString(36).substring(7);
			string = string.replace("%%id_file%%",id_file);
			string = string.replace("%%id_file%%",id_file);
			string = string.replace("%%id_file%%",id_file);
			$(".ru-list-variant").css("display","block");
			$(".ru-list-variant #accordion1").append(string);
			openImg(id_file);
			openAvatar(id_name);
			removeBienThe(id_file);
			variant_save(id_file);	
			e.preventDefault();
		}); 
		
	}	
	function openAvatar(id_name){
		$("#"+id_name+" .js-fileVariantThumbDie").on("click",function(evt){
			_this = $(this);	
			_this.parent().remove('.img');
			$('input[name="imageVariant"]').val();
		})	
		$("#"+id_name+" .js-fileVariantThumb").on("change",function(evt){	
			evt.stopPropagation();
			evt.preventDefault();
			_this = $(this);
			var files = evt.target.files;	 
			var file = files[0];		  
			var fileReader = new FileReader(); 
			fileReader.onload = function(progressEvent) {
				var url = fileReader.result;					
				_this.parent().before('<div class="img" style="padding: 8px 20px 0px;border-radius: 0 0 3px 3px;"><img src="'+url+'" style="max-width: 210px; max-height: 250px; margin-top:5px;"></div>');
			}
			fileReader.readAsDataURL(file);
		});	
	}
	function openImg(id_file,remove = true){		
		$("#"+id_file).change(function(ev) {				
			_this = $(this).closest(".variant-img");
			if(remove)
				_this.find(".img").remove();
			_files = ev.target.files;
			//_files = $(this).get(0).files				
			
			$.each(_files,function(i,v){	
				var reader = new FileReader(); 
				var fileReader = new FileReader();
				fileReader.onload = function(e) {
					src = e.target.result;
					_this.find(".ru-openImg").after('<div class="img"><img src="'+src+'"></div>');
				};
				fileReader.onerror = function() {
					$.gritter.add({
						title: 'Thông Báo',
						text: 'Lỗi lấy File ảnh',
						class_name: 'color error'
					});
				};
				fileReader.readAsDataURL(v);
			});	
		});
	}	
	function removeBienThe(id_file){		
		$("#ru-"+id_file+"-remove-bienthe").click(function(e){						
			if($("#ru-"+id_file+"-remove-bienthe").attr("data-id") == "0"){
				$("#ru-"+id_file+"-remove-bienthe").closest(".panel-default").remove();
			}else{
				//console.log("ajax xoa no");
				fd = new FormData();
				fd.append('id', $("#ru-"+id_file+"-remove-bienthe").attr("data-id"));
				fd.append('ru_csrf_token_name',ru_csrf_token_name);
				$.ajax({
					url: path_full + "/products/variant_delete_ajax",
					data: fd,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success: function(data){
						if(data.status == "200"){
							$("#ru-"+id_file+"-remove-bienthe").closest(".panel-default").remove();
							$.gritter.add({
								title: 'Thông Báo',
								text: data.msg,
								class_name: 'color success'
							});					
						}else{	
							$.gritter.add({
								title: 'Thông Báo',
								text: data.msg,
								class_name: 'color danger'
							});
						}   
					},error: function() {			
					}
				});//$.ajax */
			}
			
			e.preventDefault();
		});

	}
	function variant_save(id_file) {
	  $("."+id_file).click(function(e){
	  	console.log("lưu biến thể");
	  	e.preventDefault();
	  	var _this = $(this);
	  	var box = $("#"+_this.attr("data-parent"));
	  	var attrib_id = _this.attr("data-id");
	  	var attrib_name = _this.attr("data-name");
	  	var id_product = _this.attr("data-product");
	  	var price = box.find(".variant_price").val();
	  	var title = box.find(".variant_title").val();
	  	var imageVariant = box.find("input[name='imageVariant']")[0].files[0];

	  	fd = new FormData();
	  	fd.append('ru_csrf_token_name',ru_csrf_token_name);
	  	fd.append('title', title);
		fd.append('attrib_id', attrib_id);
		fd.append('attrib_name', attrib_name);
		fd.append('id_product', id_product);
		fd.append('price', price);
		fd.append("avatar", imageVariant);
		box.addClass("box-loader");
		$.ajax({
			url: path_full + "/products/variant_ajax",
			data: fd,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function(data){
				if(data.status == "200"){				
					$("#ru-"+id_file+"-remove-bienthe").attr("data-id",data.content);					
			    	$.gritter.add({
			    		title: 'Thông Báo',
			    		text: data.msg,
			    		class_name: 'color success'
			    	}); 
			    	uploadFile(id_file,data.content,id_product);
				}else{
					$.gritter.add({
							title: 'Thông Báo',
							text: data.msg,
							class_name: 'color error'
					});
				}   
				box.removeClass("box-loader");	
			},error: function() {	
				box.removeClass("box-loader");		
			}
		});//$.ajax */

	  	
	  })
	}
	function uploadFile(id_file,id_variant,id_product){
		var formData = new FormData();
		formData.append('ru_csrf_token_name',ru_csrf_token_name);
		_files = $("#"+id_file); 
		formData.append("id_variant",id_variant);
		formData.append("id_product",id_product);
		if(_files.get(0).files.length <= 0) return;

		for(var i=0;i<_files.get(0).files.length;i++){
			formData.append("file[]", _files.get(0).files[i]);
		}
		$.ajax({
		   		url: path_full + "/products/variant_upload_file_ajax", 
		   		type: "POST", 
		   		processData:false,
		   		cache: false,
		   		async: true,
		   		data: formData,
		   		contentType: false,
		   		success:function(datat){
		   			$.gritter.add({
		   				title: 'Thông Báo',
		   				text: "Hoàn tất tải hình ảnh",
		   				class_name: 'color success'
		   			}); 
		   		},
		   		error:function(data){
		   			$.gritter.add({
		   				title: 'Thông Báo',
		   				text: "Lỗi ngoại tệ",
		   				class_name: 'color danger'
		   			}); 
		   		}
		});
	}
	function removeFile(_this){
		var formData = new FormData();		
		formData.append('ru_csrf_token_name',ru_csrf_token_name);
		formData.append("id",_this.attr("data-id"));
		formData.append("img",_this.attr("data-name"));
		$.ajax({
			url: path_full + "/products/variant_remove_file_ajax", 
			type: "POST", 
			processData:false,
			cache: false,
			async: true,
			data: formData,
			contentType: false,
			success:function(datat){
				_this.parents(".img").remove();
				$.gritter.add({
					title: 'Thông Báo',
					text: data.msg,
					class_name: 'color success'
				}); 
			},error:function(data){
				$.gritter.add({
					title: 'Thông Báo',
					text: data.msg,
					class_name: 'color error'
				}); 
			}
		});
	}
</script>
<?php
$block_attrib_check = json_decode($getcsdl->attrib_check);		
if(!empty($block_attrib_check))	: 
?>			
<div class="form-group">
	<label class="col-sm-2 control-label">Tạo biến thể</label>	
	<div class="col-sm-8">
		<select multiple="" class="select2" name="variant[]" id="variant">		
		</select>		
	</div>	
	<div class="col-sm-2"><button id="create_variant" class="btn btn-success btn-lg" style="height: 45px;" type="button">Tạo Biến Thể SP</button></div>
</div>	
<?php if(count($products_variant) > 0): ?>
<div id="box-variant" class="form-group" style="display: block;">
<?php else: ?>
<div id="box-variant" class="form-group" style="display: none;">
<?php endif; ?>		
	<label class="col-sm-2 control-label"></label>
	<div class="col-sm-10">
		<div class="ru-variant">
			<label>Thuộc Tính</label>				
			<div class="ru-variant-box">
			</div>
		</div>
		<?php if(count($products_variant) > 0): ?>
		<div class="ru-list-variant">	
		<?php else: ?>	
		<div class="ru-list-variant" style="display: none;">	
		<?php endif; ?>	
			<div id="accordion1" class="panel-group accordion">
				<?php 
				if(count($products_variant) > 0): ?>
				<?php foreach ($products_variant as $key => $value):?>
				<div class="panel panel-default">	
				    <div class="panel-heading">
				    	<h4 class="panel-title">
				    		<a data-toggle="collapse" data-parent="#accordion1" href="#ru-variant-<?php echo $value->id ?>" class="collapsed">
				    		<i class="icon mdi mdi-chevron-down"></i> <?php echo $value->name ?> <?php echo (!empty($value->title)?" (".$value->title.")":"") ?></a>
				    	</h4>
				    </div>
				    <div id="ru-variant-<?php echo $value->id ?>" class="panel-collapse collapse">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label">Tiêu đề</label>
								<div class="col-sm-10">
									<div class="input-group xs-mb-10">						
										<input style="width:285px" type="text" value="<?php echo $value->title ?>" class="variant_title form-control input-sm">
									</div>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-2 control-label">Mã lưu kho SKU</label>
								<div class="col-sm-10">
									<div class="input-group xs-mb-10">
										<input style="width:250px" type="text" value="<?php echo $value->sku ?>" class="form-control input-sm">
									</div>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-2 control-label">Giá bán</label>
								<div class="col-sm-10">
									<div class="input-group xs-mb-10">
										<span class="input-group-addon">$</span>
										<input style="width:250px" type="text" value="<?php echo $value->price ?>" class="variant_price form-control input-sm">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Hình đại diện</label>
								<div class="col-sm-10">
									<div class="imageupload">	
									<?php	
									if(!empty($value->avatar)):
										$img = $this->ruadmin->geturlimg($value->avatar,$dir_variant.$value->id);
									?>	
										<div class="img" style="padding: 8px 20px 0px;border-radius: 0 0 3px 3px;"><img style="max-width: 100%" src="<?php echo $img ?>"></div>	
									<?php endif ?>					
										<div class="panel-body">				
										<br>			
											<label class="btn btn-default btn-file js-fileVariantThumb">
												<span>Browse</span>
												<input type="file" name="imageVariant" class="">
											</label>
											<button type="button" class="btn btn-default js-fileVariantThumbDie">Xóa</button>
										</div>
									</div>
								</div>
								<script type="text/javascript">
									$(document).ready(function(e) {	
										openAvatar("ru-variant-<?php echo $value->id ?>");
									});												
								</script>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<div class="input-group xs-mb-10 variant-img">						
										<div class="ru-openImg btn btn-space btn-danger btn-big">
											<input multiple="" type="file" accept="image/*" id="ru-imgup-<?php echo $value->id ?>" /> 
											<script type="text/javascript">
												$(document).ready(function(e) {	
													openImg("ru-imgup-<?php echo $value->id ?>",false);
													variant_save("ru-imgup-<?php echo $value->id ?>");	
												});												
											</script>
											<i class="icon mdi mdi-collection-image"></i>
											<font _mstmutation="1"> Chọn Hình </font>
										</div>
										<?php if(!empty($value->media)): ?>	
										<?php foreach ($value->media as $_key => $_value): ?>
										<div class="img">
											<span data-id="<?php echo $value->id ?>" data-name="<?php echo $_value ?>" class="ru-v-remove mdi mdi-close-circle"></span>
											<img src="<?php echo $this->ruadmin->geturlimg($_value,$dir_variant.$value->id); ?>">
										</div>		
										<?php endforeach ?>	
										<?php endif ?>														
									</div>
								</div>
							</div>	
							<div class="form-group" style="border-top:1px solid #4285f4">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-10">
									<button data-id="<?php echo $value->data_id ?>" data-name="<?php echo $value->name ?>" data-parent="ru-variant-<?php echo $value->id ?>"  data-product="<?php echo $getcsdl->id ?>" class="ru-variant-save btn btn-space btn-primary ru-imgup-<?php echo $value->id ?>">
										Lưu Biến Thể
									</button>
									<button class="ru-variant-die btn btn-space btn-danger" data-id="<?php echo $value->id ?>">Xóa Biến Thể</button>	
								</div>
							</div>	
									
						</div>
				    </div>
				</div>  				
				<?php endforeach ?>
				<?php endif; ?>	
			</div>     
		</div>
	</div>
</div>

<?php endif ?>
<script type="text/html" id="temp_ru-list-variant">
<div class="panel panel-default">	
    <div class="panel-heading">
    	<h4 class="panel-title">
    		<a data-toggle="collapse" data-parent="#accordion1" href="#%%id_name%%" class="collapsed">
    		<i class="icon mdi mdi-chevron-down"></i> %%name%%</a>
    	</h4>
    </div>
    <div id="%%id_name%%" class="panel-collapse collapse">
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-2 control-label">Tiêu đề</label>
				<div class="col-sm-10">
					<div class="input-group xs-mb-10">						
						<input style="width:285px" type="text" value="" class="variant_title form-control input-sm">
					</div>
				</div>
			</div>			
			<div class="form-group">
				<label class="col-sm-2 control-label">Giá bán</label>
				<div class="col-sm-10">
					<div class="input-group xs-mb-10">
						<span class="input-group-addon">$</span>
						<input style="width:250px" type="text" value="" class="variant_price form-control input-sm">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Hình đại diện</label>
				<div class="col-sm-10">
					<div class="imageupload">						
						<div class="panel-body">				
						<br>			
							<label class="btn btn-default btn-file js-fileVariantThumb">
								<span>Browse</span>
								<input type="file" name="imageVariant" class="">
							</label>
							<button type="button" class="btn btn-default js-fileVariantThumbDie">Xóa</button>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Hình Slider</label>
				<div class="col-sm-10">
					<div class="input-group xs-mb-10 variant-img">						
						<div class="ru-openImg btn btn-space btn-danger btn-big">
							<input multiple="" type="file" accept="image/*" id="%%id_file%%" onclick="this.value=null;"/> 
							<i class="icon mdi mdi-collection-image"></i>
							<font _mstmutation="1"> Chọn Hình </font>
						</div>						
					</div>
				</div>
			</div>	
			<div class="form-group" style="border-top:1px solid #4285f4">
				<label class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<button %%data_id%% data-name="%%name%%" data-parent="%%id_name%%"  data-product="<?php echo $getcsdl->id ?>" class="ru-variant-save btn btn-space btn-primary %%id_file%%">
						Lưu Biến Thể
					</button>
					<button id="ru-%%id_file%%-remove-bienthe" class="btn btn-space btn-danger ru-remove-bienthe" data-id="0">Xóa Biến Thể</button>	
				</div>
			</div>	
					
		</div>
    </div>
</div>    
</script>
<script type="text/javascript">
	function getAttribGroup(variant){//lấy danh sách thuộc tính để tạo biến thể		
		$.ajax({
			url: path_full+'/products/attrib_in_product_ajax',
			data: {'id':"<?php echo $getcsdl->id ?>",'ru_csrf_token_name':ru_csrf_token_name},	
			type: 'POST',
			success: function(data){
				variant.empty();
				variant.select2('data', null);
				variant.select2({
					width: "100%",
					data: data
				});										
			},error: function() {	
				console.log('Lỗi ajax');					
			}
		});//$.ajax
	}
	$(document).ready(function(e) {			
		$(".ru-v-remove").click(function(){
			removeFile($(this));
		});	
		var variant = $('#variant');	
		getAttribGroup(variant);
		//variant_save();
		
		$("#create_variant").click(function(e){			
			var data_variant = $("#variant").val();
			if(data_variant.length <= 0){
				$.gritter.add({
					title: 'Thông Báo',
					text: 'Chưa chọn thuộc tính của biến thể.',
					class_name: 'color error'
				});
				return;
			}
			var _this = $(this);
			fd = new FormData();
			fd.append('ru_csrf_token_name',ru_csrf_token_name);
			fd.append('id', "<?php echo $getcsdl->id ?>");
			for (var i = 0; i < data_variant.length; i++) {
			    fd.append('attrib_group[]', data_variant[i]);
			}
			$.ajax({
				url: path_full + "/products/variant_attrib_ajax",
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success: function(data){
					if(data.status == "200"){
						$("#box-variant").css("display","block");
						$(".ru-variant-box").html("")
						var content = JSON.parse(data.content);	
						$.each(content,function(i,v){
							var string = '<div class="ru-variant-item"><select class="select3" name="variant_attrib[]">';							
							$.each(v,function(_i,_v){								
								string += '<option value="'+_v['id']+'">'+_v['text']+'</option>';
							});
							string += '</select></div>';
							$(".ru-variant-box").append(string);	
							$('.select3').select2({width:"100%"});
						});						
						addVariant();	
					}else{
						$.gritter.add({
							title: 'Thông Báo',
							text: 'Không tạo được biến thể.',
							class_name: 'color danger'
						});
					}   
				},error: function() {			
				}
			});//$.ajax */
			e.preventDefault();
		});

		$(".ru-variant-die").click(function(e){
			_this = $(this);
			fd = new FormData();
			fd.append('ru_csrf_token_name',ru_csrf_token_name);
			fd.append('id', _this.attr("data-id"));
			$.ajax({
				url: path_full + "/products/variant_delete_ajax",
				data: fd,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				success: function(data){
					if(data.status == "200"){
						_this.closest(".panel-default").remove();	
						$.gritter.add({
							title: 'Thông Báo',
							text: data.msg,
							class_name: 'color danger'
						});					
					}else{	
						$.gritter.add({
							title: 'Thông Báo',
							text: data.msg,
							class_name: 'color danger'
						});
					}   
				},error: function() {			
				}
			});//$.ajax */
			e.preventDefault();
		});

	});	
	

</script>

