<div id="attib_insert_<?php echo $set_attrib->id ?>" class="tab-pane <?php echo ($active==TRUE)?'active':'' ?> cont">
	<div class="form-group">	
		<div class="col-sm-12"> 
		<?php 
		if(!empty($getcsdl_attrib) && !validation_errors()) 
			$content =  $getcsdl_attrib->content;
		else 
			$content =  set_value($getcsdl->id.'_'.$set_attrib->id);	
			$this->load->view("blockmodule/froalaeditor.php",array("name"=>$getcsdl->id.'_'.$set_attrib->id,"content_froalaeditor"=>$content));
		?>
		</div>
	</div>
</div>