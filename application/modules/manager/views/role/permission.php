<script src='<?php echo base_url()?>assets/js/jquery-ui-1.8.24.min.js' type="text/javascript"></script>
<link href="<?php echo base_url()?>assets/css/ui.dynatree.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>assets/js/jquery.dynatree.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#tree").dynatree({
      checkbox: true,     
      selectMode: 3,
      children: [
	  <?php
	  	$sub = NULL;
		$pa = NULL;
		
	  	foreach(@$permission as $row){
			$pid = $this->Rurole_model->role_function_pid($row->controller_id);
			if(!$pid){
				$pa .='{title: "'.$row->controller_title.'", key: "0"},';
			}else{
				foreach($pid as $rowpid){
					$cselect = NULL;
					if(isset($select)){
						foreach($select as $keys => $rows){											
							if($rowpid->function_id == $keys){								
								$cselect = ', select: true';
								break;
							}							
						}//{"4":[1]}
					}
					$sub .= '{title: "'.$rowpid->function_title.'", key: "\"'.$rowpid->function_id.'\":[1]"'.$cselect.'},';
				}
				$pa .= '{title: "'.$row->controller_title.'", isFolder: true, key: "0",
						  children: [
							'.substr($sub,0,-1).'
						  ]
						},';
				$sub = NULL;
			}
			
		}
		echo substr($pa,0,-1);
	  ?>       
        
      ],
	 	onSelect: function(select, node) {
				// Get a list of all selected nodes, and convert to a key array:
				var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
					return node.data.key;
				});
				
		}
    });
	$("#send").click(function(){		
		var formData = $(this).serializeArray();
		formData.push({name: "ru_csrf_token_name", value: ru_csrf_token_name});
		
		var tree = $("#tree").dynatree("getTree");
      	formData = formData.concat(tree.serializeArray());		
		if(tree.getActiveNode()){			
			formData.push({name: "activeNode", value: tree.getActiveNode().data.key});
		}

		
		$.post(path_full + "<?php echo "/Role/modify/".$getcsdl->role_id;?>",formData,
			function(s){
				if(s.tt == "true"){
						$.gritter.add({
							title: 'Thông Báo',
							text: s.msg,
							image: path + 'assets/img/avatar.png',
							time: '500',
							class_name: 'img-rounded',
							after_close: function(e, manual_close){
								location.reload();
							}
						});
						
					}else{
						$.gritter.add({
							title: 'Thông Báo',
							text: s.msg,
							time: '',
							class_name: 'color danger'
						});
					}
			}
      );
      return false;
	});	
	

});
</script>
<ol class="breadcrumb">
	<li><a href="<?php echo base_url().$module?>"><span class="icon mdi mdi-home"></span></a></li>
	<li><a href="<?php echo base_url().$module."/".$controller?>">Phân Quyền</a></li>
	<li class="active"><?php echo $title ?></li>
</ol>
<div class="panel panel-default panel-table">

                <div class="panel-heading">
                	Cấp Quyền Cho : <strong><?php echo $getcsdl->role_name ?></strong>
                </div>
                <div class="main-content container-fluid">
					<div class="panel-body">
                		<div id="tree" name="selNodes[]" style="margin-top:10px;margin-bottom:10px;"></div>
                    </div>
                    <button class="btn btn-space btn-primary hover" id="send">Thực Hiện</button>
                </div>
                
              </div>